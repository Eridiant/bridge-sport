<?php
if (!$model->show && $model->user_id !== Yii::$app->user->id) {
    return;
}
if ($model->deleted_at) {
    if (count($model->answers)) { ?>
                <p class="messages-user">
                    <?= $model->user->username; ?>
                </p>
                <div class="messages-text">
                    Сообщение удалено
                </div>
                <div class="messages-footer">
                    <div class="messages-answer" data-message-id="<?= $model->id; ?>" data-user="<?= $model->user->username; ?>" data-user-id="<?= $model->user->id; ?>">
                        <?php if ($model->user->id === Yii::$app->user->id && Yii::$app->user->can('canMessage')): ?>
                            <a href="#" data-edit="0">Восстановить</a>
                        <?php endif; ?>
                    </div>
                </div>
    <?php
        return;
    } else {
        return;
    }
}
?>
                    <div class="messages-header">
                        <div class="messages-user">
                            <?= $model->user->username; ?>
                        </div>
                        <?php if ($model->answer_user): ?>
                            <p>ответил <?= $model->answer->username; ?>'у</p>
                        <?php endif; ?>
                    </div>
                    <div class="messages-text">
                        <?= $model->message; ?>
                    </div>
                    <div class="messages-footer">
                        <span><?= Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d H:m'); ?></span>
                        <div class="messages-answer" data-message-id="<?= $model->id; ?>" data-user="<?= $model->user->username; ?>" data-user-id="<?= $model->user->id; ?>">
                        <?php if (Yii::$app->user->can('canMessage')): ?>
                            <a href="#">Ответить</a>
                            <?php if ($model->user->id === Yii::$app->user->id): ?>
                                <!-- <a href="#" data-edit="1">Редактировать</a> -->
                                <a href="#" data-edit="0">Удалить</a>
                            <?php endif; ?>
                        <?php endif; ?>
                        </div>
                    </div>
