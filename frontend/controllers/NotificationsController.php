<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Notifications;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificationsController implements the CRUD actions for Notifications model.
 */
class NotificationsController extends AppController
{

    /**
     * Lists all Notifications models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Notifications::find()
            ->joinWith('reply')
            ->where(['{{%notifications}}.user_id' => [Yii::$app->user->id, null], 'show' => [1, null]])
            ->andWhere(['>', '{{%notifications}}.created_at', Yii::$app->user->identity->created_at])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', compact('model'));
    }



    /**
     * Finds the Notifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Notifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notifications::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
