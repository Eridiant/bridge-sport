<div class="messages" data-post="<?= $model->id; ?>">
    <p class="messages-title">Обсуждение</p>
    <?php foreach ($model->messages as $message): ?>
        <div class="messages-wrapper">
            <?= $this->render('_messages', ['model' => $message]); ?>
            <?php foreach ($message->messageReplies as $reply): ?>
                <div class="messages-inner">
                    <?= $this->render('_reply', ['model' => $reply]); ?>
                </div>
            <?php endforeach; ?>
            <?php if (Yii::$app->user->can('canMessage') && ($message->show || $message->user_id === Yii::$app->user->id) && (!$message->deleted_at || count($message->messageReplies))): ?>
                <div class="messages-form hide">
                    <p class="messages-reply"></p>
                    <div class="messages-textarea" contentEditable></div>
                    <div class="messages-btn">
                        <svg width="36" height="36"><use xlink:href="/images/icons.svg#button-arrow"></use></svg>
                    </div>
                    <p class="messages-errors"></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <?php if (Yii::$app->user->can('canMessage')): ?>
        <div class="messages-form msg">
            <div class="messages-textarea msg" contentEditable></div>
            <div class="messages-btn">
                <svg width="36" height="36"><use xlink:href="/images/icons.svg#button-arrow"></use></svg>
            </div>
            <p class="messages-errors"></p>
        </div>
    <?php endif; ?>
</div>