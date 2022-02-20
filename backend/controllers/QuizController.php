<?php

namespace backend\controllers;

use Yii;
use backend\models\Quiz;
use backend\models\QuizSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuizController implements the CRUD actions for Quiz model.
 */
class QuizController extends Controller
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
                        'delete' => ['POST', 'GET'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Quiz models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new QuizSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');

        return $this->render('edit', compact('id'));
    }

    public function actionCheck($id = null)
    {
        $request = Yii::$app->request;

        if ($this->request->isPost) {
            if ($id == null) {
                $model = new Quiz();
            } else {
                $model = $this->findModel($id);
            }
            if ($model->load($this->request->post()) && $model->save()) {
                $id = $this->request->get('survey_id');
                return $this->render('edit', compact('id'));
            }
        }

        

        $model = Quiz::find()
                ->where(['parent_id' => $request->get('parent_id'), 'survey_id' => $request->get('survey_id')]);
        
        if (!empty($request->get('answer_id'))) {
            $model = $model->andWhere(['answer_id' => $request->get('answer_id')]);
        }
        
        $model = $model->one();
        // $searchModel = new QuizSearch();
        // $dataProvider = $searchModel->search($this->request->queryParams);
        if (!empty($model)) {
            return $this->render('update', compact('model'));
        }

        $model = new Quiz();

        $model->parent_id = $request->get('parent_id');
        $model->survey_id = $request->get('survey_id');
        $model->answer_id = $request->get('answer_id');
        
        return $this->render('create', compact('model'));
    }

    /**
     * Displays a single Quiz model.
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
     * Creates a new Quiz model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Quiz();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $model->survey_id = Yii::$app->request->get('id');

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Quiz model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                return $this->redirect(['edit', 'id' => $model->survey_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Quiz model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Quiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Quiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quiz::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
