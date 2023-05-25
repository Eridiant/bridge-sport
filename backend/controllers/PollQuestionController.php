<?php

namespace backend\controllers;

use Yii;
use backend\models\poll\PollQuestion;
use backend\models\poll\PollAnswer;
use backend\models\poll\PollResult;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PollQuestionController implements the CRUD actions for PollQuestion model.
 */
class PollQuestionController extends AppController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all PollQuestion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PollQuestion::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PollQuestion model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PollQuestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $id = Yii::$app->request->get('id') ?? Yii::$app->request->post('id');

        $model = PollQuestion::find()
            // ->where(['poll_id' => $id])
            ->where('poll_id=:poll_id')
            ->addParams([':poll_id' => $id])
            ->all();

        // if ($this->request->isPost) {

        //     if ($model->load($this->request->post()) && $model->save()) {
        //         return $this->redirect(['view', 'id' => $model->id]);
        //     }
        // } else {
        //     $model->loadDefaultValues();
        // }

        return $this->render('create', compact('model', 'id'));
    }

    public function actionCreateQuestion()
    {
        if (!$this->request->isPost)
            return;

        $request = Yii::$app->request;
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($id = $request->post('question_id')) {
            $model = $this->findModel($id);
        } else {
            $model = new PollQuestion();
        }

        if ($request->post('text') || $request->post('comment')) {
            $model->poll_id = $request->post('poll_id');
            if ($request->post('text')) {
                $model->text = trim($request->post('text'));
            }
            $model->type = $request->post('type') ?? 0;
            if ($request->post('comment')) {
                $model->comment = trim($request->post('comment'));
            }
            if ($model->save()) {
                // return ['data' => ['id' => 1, 'type' => 2]];
                return ['data' => ['id' => $model->id, 'type' => $model->type]];
            } else {
                return ['error' => $model->errors];
            }
        }

        $render = $this->renderPartial('_question', compact('model'));
        return ['response' => $render];
    }

    public function actionDeleteQuestion()
    {
        $request = Yii::$app->request;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($id = $request->post('question_id')) {
            $model = $this->findModel($id);
        }

        if ($model->delete()) {
            return ['success' => true];
        }
    }

    public function actionCreateAnswer()
    {
        if (!$this->request->isPost)
            return;

        $request = Yii::$app->request;
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($id = $request->post('answer_id')) {
            $answer = PollAnswer::find()
                ->where('id=:id')
                ->addParams([':id' => $id])
                ->one();
        } else {
            $answer = new PollAnswer();
        }

        if ($request->post('text')) {
            $answer->question_id = $request->post('question_id');
            $answer->text = trim($request->post('text'));
            if ($answer->save()) {
                // return ['data' => ['id' => 1, 'type' => 2]];
                return ['data' => ['id' => $answer->id, 'question_id' => $answer->question_id]];
            } else {
                return ['error' => $answer->errors];
            }
        }

        $render = $this->renderPartial('_answer', compact('answer'));
        return ['response' => $render];
    }

    public function actionDeleteAnswer()
    {
        $request = Yii::$app->request;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($id = $request->post('answer_id')) {
            $model = PollAnswer::find()
                    ->where('id=:id')
                    ->addParams([':id' => $id])
                    ->one();
        }

        if ($model->delete()) {
            return ['success' => true];
        }
    }

    public function actionCreateResult()
    {
        if (!$this->request->isPost)
            return;

        $request = Yii::$app->request;
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($id = $request->post('result_id')) {
            $result = PollResult::find()
                ->where('id=:id')
                ->addParams([':id' => $id])
                ->one();
        } else {
            $result = new PollResult();
        }

        if ($request->post('text')) {
            $result->answer_id = $request->post('answer_id');
            $result->text = trim($request->post('text'));
            $result->is_correct = $request->post('is_correct');
            if ($result->save()) {
                // return ['data' => ['id' => 1, 'type' => 2]];
                return ['data' => ['id' => $result->id, 'answer_id' => $result->answer_id]];
            } else {
                return ['error' => $result->errors];
            }
        }

        $render = $this->renderPartial('_result', compact('result'));
        return ['response' => $render];
    }

    public function actionDeleteResult()
    {
        $request = Yii::$app->request;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($id = $request->post('result_id')) {
            $model = PollResult::find()
                    ->where('id=:id')
                    ->addParams([':id' => $id])
                    ->one();
        }

        if ($model->delete()) {
            return ['success' => true];
        }
    }

    /**
     * Updates an existing PollQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PollQuestion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PollQuestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PollQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PollQuestion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
