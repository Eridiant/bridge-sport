<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Post;
use frontend\models\Answer;
use frontend\models\Quiz;
use frontend\models\Survey;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SurveyController implements the CRUD actions for Post model.
 */
class SurveyController extends Controller
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
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Survey::find()->all();

        return $this->render('index', compact('model'));
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['data' => ['success' => true]];
        }
        $model = Survey::find()->where(['slug' => $slug])->one();
        
        return $this->render('view', compact('model'));
    }

    public function actionQuiz($survey_id, $parent_id = 0)
    // public function actionQuiz()
    {
        $request = Yii::$app->request;
        var_dump('<pre>');
        var_dump($survey_id);
        var_dump('</pre>');
        die;
        
        if ($request->isPost) {
            $model = Quiz::find()
                    ->where(['survey_id=:survey_id', 'parent_id=:parent_id'])
                    ->addParams([':survey_id' => $survey_id, ':parent_id' => $parent_id])
                    ->one();
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            return json_encode(['model' => $model]);
        }
        return ['data' => ['success' => false]];
        $model = Survey::find()->where(['slug' => $slug])->one();
        
        return $this->render('view', compact('model'));
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
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
     * Deletes an existing Post model.
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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
