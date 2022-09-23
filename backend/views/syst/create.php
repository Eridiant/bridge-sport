<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Syst */

$this->title = 'Create Syst';
$this->params['breadcrumbs'][] = ['label' => 'Systs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syst-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
