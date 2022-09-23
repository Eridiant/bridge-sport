<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SysItm */

$this->title = 'Update: ' . $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Sys Itms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sys-itm-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
