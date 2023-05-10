<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\stm\StmSystem $model */

$this->title = 'Update Stm System: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Stm Systems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stm-system-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
