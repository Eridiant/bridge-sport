<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Syst */

$this->title = 'Update Syst: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Systs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="syst-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
