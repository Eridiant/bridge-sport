<?php
use yii\helpers\Html;

?>
<div class="poll-answer dlt" data-answer-id="<?= $answer->id ?? ''; ?>">
    <span class="poll-content" contenteditable="false">
        <?= $answer->text ?? ''; ?>
    </span>
    <?= Html::a('&#10008;', ['/poll-question/delete-answer'], ['class' => 'delete-answer delete']) ?>
    <div class="poll-result-wrapper poll-wrap">
        <div class="poll-result poll-inner">
            <?php if (isset($answer->result)): ?>
                <?= $this->render('_result', [
                    'result' => $answer->result
                ]) ?>
            <?php endif; ?>
        </div>
        <?php if (is_null($answer->result)): ?>
            <?= Html::a('&#10010;', ['/poll-question/create-result'], ['class' => 'add-result']) ?>
        <?php endif; ?>
    </div>
</div>