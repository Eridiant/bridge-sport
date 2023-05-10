<?php

use backend\models\stm\StmSystem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Stm Systems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stm-system-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Stm System', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'type',
            'name',
            // 'slug',
            //'description:ntext',
            //'hidden',
            //'edit',
            //'updated_at',
            //'created_at',

            [
                'label' => 'Система',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('Редактировать', ['/stm-bid/edit', 'id' => $model->id], ['class' => 'profile-link']);
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, StmSystem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
