<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Attribute */

$this->title = 'Update Attribute: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="attribute-update">

    <?= $this->render('_form', compact('model')) ?>

</div>
