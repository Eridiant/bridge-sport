<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\poll\PollQuestion $model */

$this->title = 'Create Poll Question';
$this->params['breadcrumbs'][] = ['label' => 'Poll Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="question" class="poll-question-create poll-wrap">

    <div class="poll-question-wrapper poll-inner" id="poll" data-poll-id="<?= $id ?? ''; ?>">
        <?php foreach ($model as $model): ?>
            <?= $this->render('_question', compact('model')) ?>
        <?php endforeach; ?>
    </div>

    <?= Html::a('&#10010;', ['/poll-question/create-question'], ['class' => 'add-question']) ?>

</div>
