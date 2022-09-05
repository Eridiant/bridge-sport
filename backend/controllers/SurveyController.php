<?php

namespace backend\controllers;

use Yii;
use backend\models\Survey;
use backend\models\SurveySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SurveyController implements the CRUD actions for Survey model.
 */
class SurveyController extends AppController
{
    /**
     * @inheritDoc
     */
    // public function behaviors()
    // {
    //     return array_merge(
    //         parent::behaviors(),
    //         [
    //             'access' => [
    //                 'class' => AccessControl::class,
    //                 'rules' => [
    //                     [
    //                         'actions' => ['login', 'error'],
    //                         'allow' => true,
    //                     ],
    //                     [
    //                         'actions' => ['index', 'view', 'quiz', 'create', 'update', 'delete'],
    //                         'allow' => true,
    //                         'roles' => ['@'],
    //                     ],
    //                 ],
    //             ],
    //             'verbs' => [
    //                 'class' => VerbFilter::class,
    //                 'actions' => [
    //                     'delete' => ['POST', 'GET'],
    //                 ],
    //             ],
    //         ]
    //     );
    // }

    /**
     * Lists all Survey models.
     *
     * @return string
     */
    public function actionIndex()
    {
        // $this->request->queryParams += ["type"=>"1"];
        // var_dump('<pre>');
        // var_dump($this->request->queryParams);
        // var_dump('</pre>');
        // die;
        $searchModel = new SurveySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionQuiz()
    {
        $this->request->queryParams += ["SurveySearch"=>["type"=>"2"]];
        // $this->request->queryParams["SurveySearch"] += ["type"=>"2"];
        // var_dump('<pre>');
        // var_dump($this->request->queryParams["SurveySearch"]);
        // var_dump($this->request->queryParams);
        // var_dump('</pre>');
        // die;
        // ?SurveySearch[type]=1
        
        $searchModel = new SurveySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('quiz', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Survey model.
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
     * Creates a new Survey model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Survey();

        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $model->user_id = Yii::$app->user->getId();
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    var_dump('<pre>');
                    var_dump($model->getErrors());
                    var_dump('</pre>');
                    die;
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Survey model.
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
     * Deletes an existing Survey model.
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
     * Finds the Survey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Survey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Survey::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
