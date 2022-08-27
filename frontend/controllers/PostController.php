<?php

namespace frontend\controllers;

use frontend\models\Post;
use frontend\models\PostSearch;
use frontend\models\Quiz;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionShow($id)
    {
        $model = $this->findModel($id);

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
        $model = Post::find()
            ->with('image')
            ->where(['id' => $id])
            ->andWhere(['status' => 1])
            ->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
