<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Systems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-index">

    <p>
        <?= Html::a('Create System', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'type',
            'name',
            'slug',
            // 'description:ntext',
            // 'hidden',
            // 'edit',
            // 'updated_at',
            // 'created_at',
            [
                'label' => 'Система',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('Редактировать', ['/bid/edit', 'id' => $model->id], ['class' => 'profile-link']);
                },
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
