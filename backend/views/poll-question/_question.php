<?php
use yii\helpers\Html;

?>

<div class="poll-question dlt" data-poll-id="<?= $model->poll->id ?? ''; ?>" data-question-id="<?= $model->id ?? ''; ?>">
    <input type="checkbox" name="asdf" class="poll-question-type" <?= $model->type ? 'checked' : ''; ?>>
    <span class="poll-content" contenteditable="false">
        <?= $model->text ?? ''; ?>
    </span>
    <span class="poll-content poll-comment" contenteditable="false">
        <?= $model->comment ?? ''; ?>
    </span>
    <?= Html::a('&#10008;', ['/poll-question/delete-question'], ['class' => 'delete-question delete']) ?>
    <div class="poll-answers-wrapper poll-wrap">
        <div class="poll-answers poll-inner">
            <?php foreach ($model->answers as $answer) : ?>
                <?= $this->render('_answer', compact('answer')) ?>
            <?php endforeach; ?>
        </div>
        <?= Html::a('&#10010;', ['/poll-question/create-answer'], ['class' => 'add-answer']) ?>
    </div>
</div>