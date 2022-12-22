<?php

if (!$model->show && $model->user_id !== Yii::$app->user->id) {
    return;
}
if ($model->deleted_at && !count($model->messageReplies))
{
    return;
}
?>
<div class="messages-wrap">
    <?= $this->render('_message', compact('model')); ?>
</div>