<?php

use yii\helpers\Url;

?>
<?php foreach ($notifications as $value): ?>
    <div class="nav-inner<?= $value->created_at > $viewed_ntf ? ' new' : ''; ?>">
        <p class="messages-user">
            <?php if ($value->respondent): ?>
                <?= $value->respondent->username; ?>
            <?php else: ?>
                <?= $value->title ?: 'инкогнито'; ?>
            <?php endif; ?>
        </p>
        <div class="messages-text">
            <?php if ($value->reply): ?>
                <?= $value->reply->message; ?>
            <?php else: ?>
                <?= $value->text; ?>
            <?php endif; ?>
        </div>
        <div class="messages-answer">
            <?php if ($value->post): ?>
                <a class="blank" href="<?= Url::to(['/post', 'id' => $value->post->id]); ?>">Ответить</a>
            <?php endif; ?>
        </div>
    </div>
    <hr>
<?php endforeach; ?>