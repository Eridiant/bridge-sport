<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Syst */

$this->title = 'Create Syst';
$this->params['breadcrumbs'][] = ['label' => 'Systs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syst-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
