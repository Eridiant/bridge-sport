<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Survey */

$this->title = 'Create Survey';
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
