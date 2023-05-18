<?php
use yii\helpers\Html;

?>


<div class="poll-result dlt" data-result-id="<?= $result?->id ?? ''; ?>">
    <select name="" id="poll-correct">
        <?php for($i=1; $i<11; $i++): ?>
            <option <?= $i == $result->is_correct ? "selected" : ''; ?> value="<?= $i; ?>"><?= $i; ?></option>
        <?php endfor; ?>
    </select>
    <span class="poll-content" contenteditable="false">
        <?= $result?->text ?? ''; ?>
    </span>
    <?= Html::a('&#10008;', ['/poll-question/delete-result delete'], ['class' => 'delete-result delete']) ?>
</div>
