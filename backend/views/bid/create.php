<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\system\Bid */

$this->title = 'Create Bid';
$this->params['breadcrumbs'][] = ['label' => 'Bids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bid-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
