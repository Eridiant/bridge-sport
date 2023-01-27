<?php

namespace frontend\controllers;

use frontend\models\system\System;
use frontend\models\system\Bid;
use frontend\models\system\BidTbl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SystemController implements the CRUD actions for System model.
 */
class SystemController extends AppController
{
    /**
     * @inheritDoc
     */
    // public function behaviors()
    // {
        // return array_merge(
        //     parent::behaviors(),
        //     [
        //         'verbs' => [
        //             'class' => VerbFilter::class,
        //             'actions' => [
        //                 'delete' => ['POST'],
        //             ],
        //         ],
        //     ]
        // );
    // }

    /**
     * Lists all System models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = System::find()
            ->where(["hidden" => 0])
            ->all();

        return $this->render('index', compact('model'));
    }

    /**
     * Displays a single System model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {

        $model = System::find()
            ->where('slug=:slug')
            ->addParams([':slug' => $slug])
            ->one();

        $id = $model->id;
        $bids = $this->findBidAll();
        $pass = $this->findBidPass();

        return $this->render('view', compact('model', 'id', 'bids', 'pass'));
    }

    /**
     * Creates a new System model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new System();

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
     * Updates an existing System model.
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
     * Deletes an existing System model.
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
     * Finds the System model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return System the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findModel($id)
    // {
    //     if (($model = System::findOne(['id' => $id])) !== null) {
    //         return $model;
    //     }

    //     throw new NotFoundHttpException('The requested page does not exist.');
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
