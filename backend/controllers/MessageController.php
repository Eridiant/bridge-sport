<?php

namespace backend\controllers;

use Yii;
use backend\models\Message;
use backend\models\MessageReply;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessageController implements the CRUD actions for Message model. 
 */
class MessageController extends AppController
{
    /**
     * @inheritDoc
     */
    // public function behaviors()
    // {
    //     return array_merge(
    //         parent::behaviors(),
    //         [
    //             'verbs' => [
    //                 'class' => VerbFilter::className(),
    //                 'actions' => [
    //                     'delete' => ['POST'],
    //                 ],
    //             ],
    //         ]
    //     );
    // }

    /**
     * Lists all Message models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Message::find()->select(['id', 'user_id', 'post_id', 'message', 'history', 'show', 'created_at', 'deleted_at', 'message_id'])->where(['show' => 0]);
        
        $query2 = MessageReply::find()->select(['id', 'user_id', 'answer_id as `post_id`', 'message', 'history', 'show', 'created_at', 'deleted_at', 'message_id'])->where(['show' => 0]);
        $query->union($query2);
        // var_dump('<pre>');
        // var_dump($query->all());
        // var_dump('</pre>');
        // die;
        $dataProvider = new ActiveDataProvider([
            // 'query' => Message::find(),
            'query' => $query,
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
        // $dataProvider2 = new ActiveDataProvider([
        //     'query' => MessageReply::find(),
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
        // ]);
        // $dataProvider = array_merge($dataProvider1->getModels(), $dataProvider2->getModels());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Message model.
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
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Message();

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
     * Updates an existing Message model.
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
     * Deletes an existing Message model.
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

    public function actionShow($id)
    {
        $model = $this->findModel($id);
        $model->show = 1;
        if ($model->save()) {
            return $this->redirect(['index']);
        }
    }

    public function actionShowAll($id)
    {
        $params = [':user_id' => $id];

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $db->createCommand()
                ->update('{{%message}}', ['show' => 1], 'user_id = :user_id')
                ->bindValues($params)
                ->execute();
            $db->createCommand()
                ->update('{{%message_reply}}', ['show' => 1], 'user_id = :user_id')
                ->bindValues($params)
                ->execute();
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
        }
        // Yii::$app->db->transaction(function($db) {
            
        // });
        

        
        return $this->redirect(['index']);
    }

    public function actionDeleteAll($id)
    {
        // $params = [':user_id' => $id];
        $id = (int) $id;

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $db->createCommand()
                ->delete('{{%message}}', ['show' => 0, 'user_id' => $id])
                // ->bindValues($params)
                ->execute();
            $db->createCommand()
                ->delete('{{%message_reply}}', ['show' => 0, 'user_id' => $id])
                // ->bindValues($params)
                ->execute();
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
