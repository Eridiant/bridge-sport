<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Post;
use frontend\models\Message;
use frontend\models\MessageReply;
use frontend\models\UserInfo;
use frontend\models\Notifications;
use frontend\models\PostSearch;
use frontend\models\Quiz;
use frontend\class\IsBot;
use yii\web\NotFoundHttpException;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends AppController
{

    /**
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {

        // var_dump($this->request->queryParams);
        
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        // $dataProvider = $dataProvider->;
        $model = $dataProvider->getModels();

        // $this->setMeta('', '');
        return $this->render('index', compact('model'));
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMessage()
    {
        if (!Yii::$app->user->can('canMessage')) {
            return false;
        }

        $request = Yii::$app->request;

        if ($request->isPost) {
            $post = $request->post('post');
            $message = $request->post('message');
            $answer = $request->post('answer');
            $parent = $request->post('parent');
            $answer_id = $request->post('answerId') !== 'undefined' ? $request->post('answerId') : null;

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($parent) {
                $model = new MessageReply();
                $model->message_id = $parent;
                $model->answer_user = $arr['user_id'] = Yii::$app->user->id == $answer ? null : $answer;
                $model->user_id = Yii::$app->user->id;
                
                $model->answer_id = $answer_id;
                $model->show = (int) Yii::$app->user->can('user');
                $model->message = $message;
                if (!$model->validate()) {
                    return ['data' => ['validate' => $model->errors]];
                }
                
                if ($model->save()) {
                    if (Yii::$app->user->id != $answer) {
                        $arr['post_id'] = $model->parent->post->id;
                        $arr['reply_id'] = $model->id;
                        $arr['respondent_id'] = Yii::$app->user->id;
                        $this->addNotification($arr);
                    }
                    $render = $this->renderPartial('_reply', compact('model'));
                    return ['data' => ['reply' => $render]];
                } else {
                    return ['data' => ['error' => $model->getErrors()]];
                }
            } else {
                $model = new Message();
                $model->user_id = Yii::$app->user->id;
                $model->message = $message;
                $model->post_id = $post;
                $model->show = (int) Yii::$app->user->can('user');
                if (!$model->validate()) {
                    return ['data' => ['validate' => $model->errors]];
                }
                if ($model->save()) {
                    $render = $this->renderPartial('_xml', compact('model'));
                    return ['data' => ['message' => $render]];
                } else {
                    return ['data' => ['error' => $model->getErrors()]];
                }
            }
        }
    }

    private function addNotification($arr)
    {
        $model = new Notifications();
        $model->user_id = $arr['user_id'];
        $model->post_id = $arr['post_id'];
        $model->reply_id = $arr['reply_id'];
        $model->respondent_id = $arr['respondent_id'];
        $model->save();
        
        // return ;
    }

    public function actionDeleteMessage()
    {
        if (!Yii::$app->user->can('canMessage')) {
            return ['data' => ['error' => 'access is denied']];
        }

        $request = Yii::$app->request;

        if ($request->isPost) {

            $post = (int)$request->post('post');
            $id = (int)$request->post('id');
            $parent = (int)$request->post('parent');

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (!$parent) {
                $model = MessageReply::findOne($id);
            } else {
                $model = Message::findOne($id);
            }

            if ($model === null || $model->user_id !== Yii::$app->user->id) {
                return ['data' => ['error' => 'access is denied | model == null']];
            }

            if ($model->deleted_at === null) {
                $model->deleted_at = time();
            } else {
                $model->deleted_at = null;
            }

            if ($model->save()) {
                if (!$parent) {
                    $render = $this->renderPartial('_reply', compact('model'));
                    return ['data' => ['reply' => $render]];
                } else {
                    $render = $this->renderPartial('_xml', compact('model'));
                    return ['data' => ['message' => $render]];
                }
                
            } else {
                return ['data' => ['error' => $model->getErrors()]];
            }
        }
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionShow($id)
    {
        $model = $this->findModel($id);

        if ($model->status == 4 && IsBot::isGoogle()) {
            $model->status = 5;
            try {
                $model->save();
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        $socialImage = null;
        if (!empty($model->image) || !empty($model->iframe)) {
            $socialImage = (!empty($model->iframe->image->path) && !$model->iframe->hide) ? $model->iframe->image->path : $model->image->path;
        }

        $survey = '';
        $answer = '';
        $parent = '';
        if (!empty($model->survey)) {
            $survey_id = $model->survey->id;
            $survey = Quiz::find()
                ->where('survey_id=:survey_id')
                ->addParams([':survey_id' => $survey_id])
                ->indexBy('id')
                ->with('answers')
                ->asArray()
                ->all();
                
            $answer = Quiz::find()
                ->where('survey_id=:survey_id')
                ->addParams([':survey_id' => $survey_id])
                ->indexBy('answer_id')
                ->select(['id', 'answer_id'])
                ->asArray()
                ->all();

            $parent = Quiz::find()
                ->where('survey_id=:survey_id')
                ->addParams([':survey_id' => $survey_id])
                ->indexBy('parent_id')
                ->select(['id', 'parent_id'])
                ->asArray()
                ->all();

            // $survey = $survey

            // var_dump('<pre>');
            // print_r($survey);
            // var_dump('</pre>');
            // die;

            // $survey = json_encode($survey);
        }
        $this->setMeta(empty($model->title) ? $model->name : $model->title, empty($model->description) ? $model->preview : $model->description, $model->keywords, $socialImage);

        return $this->render('show', compact('model', 'survey', 'parent', 'answer'));
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $id = (int)$id;
        $model = Post::find()
            // ->with('image', 'messages', 'messageReply', 'replies')
            // ->with('image', 'messages')
            // ->with(['image'])
            // ->joinWith(['messages'])
            // ->where('{{%post}}.id:id', [':id' => $id])
            // ->where('id:id', [':id' => $id])
            ->where(['{{%post}}.id' => $id])
            // ->andWhere(['status' => 1])
            // ->andWhere(['status' => 1])
            ->andWhere(['>', 'status', 4])
            // ->andWhere(['show' => 1])
            ->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
