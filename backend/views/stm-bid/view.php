<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\stm\StmBid $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stm Bids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="stm-bid-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'system_id',
            'parent_id',
            'variant_id',
            'vulnerable_id',
            'pass',
            'hide',
            'alert',
            'opponent',
            'excerpt:ntext',
            'description:ntext',
            'updated_at',
            'created_at',
            'deprecated_at',
        ],
    ]) ?>

</div>
