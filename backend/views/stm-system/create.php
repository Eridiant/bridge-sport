<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\stm\StmSystem $model */

$this->title = 'Create Stm System';
$this->params['breadcrumbs'][] = ['label' => 'Stm Systems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stm-system-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
