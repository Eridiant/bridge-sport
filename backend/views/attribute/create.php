<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Attribute */

$this->title = 'Create Attribute';
$this->params['breadcrumbs'][] = ['label' => 'Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
