<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Survey */

$this->title = 'Update Survey: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="survey-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
