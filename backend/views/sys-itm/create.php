<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SysItm */

$this->title = 'Create Sys Itm';
$this->params['breadcrumbs'][] = ['label' => 'Sys Itms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-itm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
