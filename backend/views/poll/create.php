<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\poll\Poll $model */

$this->title = 'Create Poll';
$this->params['breadcrumbs'][] = ['label' => 'Polls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poll-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
