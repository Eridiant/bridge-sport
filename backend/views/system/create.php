<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\system\System */

$this->title = 'Create System';
$this->params['breadcrumbs'][] = ['label' => 'Systems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
