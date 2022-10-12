<?php

namespace common\components\notifications;

use Yii;
use yii\base\Widget;
use frontend\models\Notifications;
use frontend\models\MessageReply;
use frontend\models\User;

class NotificationsWidget extends Widget
{
    public $request;

    public function run()
    {
        $notifications = Notifications::find()
            ->joinWith('reply')
            ->where(['{{%notifications}}.user_id' => [Yii::$app->user->id, null]])
            // ->where(['{{%notifications}}.user_id' => null])
            ->andWhere(['show' => [1, null]])
            ;
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $viewed_ntf = isset($user->userInfo) ? $user->userInfo->viewed_ntf_at : $user->created_at;
        if ($this->request) {
            $count = $notifications->andWhere(['>', '{{%notifications}}.created_at', $viewed_ntf])->count();
            $count = !$count ? '' : $count;
            return $count;
        }

        $previos = isset($user->userInfo->previos_at) ? $user->userInfo->previos_at : $user->created_at;
        $notifications = $notifications
            ->andWhere(['>', '{{%notifications}}.created_at', $previos])
            ->orderBy(['id' => SORT_DESC])
            ->all();
        //
        return $this->render('notifications', compact('notifications', 'viewed_ntf'));

    }
}