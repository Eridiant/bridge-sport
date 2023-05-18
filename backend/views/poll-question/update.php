<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\poll\PollQuestion $model */

$this->title = 'Update Poll Question: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Poll Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="poll-question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
