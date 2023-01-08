<?php

namespace frontend\controllers;

use Yii;
use frontend\models\system\Bid;
use frontend\models\system\BidTbl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BidController implements the CRUD actions for Bid model.
 */
class BidController extends AppController
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
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Bid models.
     *
     * @return string
     */
    // public function actionIndex()
    // {
    //     $dataProvider = new ActiveDataProvider([
    //         'query' => Bid::find(),
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
    //     ]);

    //     return $this->render('index', [
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Displays a single Bid model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    public function actionFill()
    {
        $request = Yii::$app->request;

        $system_id = (int)$request->post('system_id');
        $parent_id = (int)$request->post('parent_id');
        $pass = $request->post('pass_count') ?? 0;
        $pass = (int)$pass;

        $sql = "SELECT {{%bid}}.id, parent_id, bid_tbl_id, pass, excerpt, `description`, num, bid 
        FROM {{%bid}}
        LEFT JOIN {{%bid_tbl}} ON {{%bid_tbl}}.id = {{%bid}}.bid_tbl_id
        WHERE system_id = {$system_id} AND parent_id = {$parent_id} AND pass = {$pass}
        ORDER BY {{%bid_tbl}}.id
        ";
        $model = \Yii::$app->db->createCommand($sql)->queryAll();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // return $model;
        return ['data' => $model];
    }

    public function actionId()
    {
        $request = Yii::$app->request;

        $id = (int)$request->post('id');

        $model = $this->findModel($id);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // return $model;
        return ['data' => $model];
    }

    public function actionView($slug)
    {

        $model = System::find()
            // ->with(['sysItms'])
            ->where('slug=:slug')
            ->addParams([':slug' => $slug])
            ->one();
        // $id = $model->id;

        $bids = $this->findBidAll();
        $pass = $this->findBidPass();

        return $this->render('view', compact('id', 'bids', 'pass'));
    }

    /**
     * Creates a new Bid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new Bid();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing Bid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Deletes an existing Bid model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Bid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Bid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bid::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findBid($id)
    {
        if (($model = BidTbl::findOne(['num' => $id])) !== null) {
            return $model->id;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findBidAll()
    {
        if (($model = BidTbl::find()->where(['>', 'lvl', 0])) !== null) {
            return $model->all();
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findBidPass()
    {
        if (($model = BidTbl::find()->where(['lvl' => 0])) !== null) {
            return $model->all();
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
