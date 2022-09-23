<?php

use backend\models\SysItm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Systs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syst-index">

    <p>
        <?= Html::a('Create Syst', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'slug',
            'description:ntext',
            [
                'label' => 'Система',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('Редактировать', ['/sys-itm/edit', 'id' => $model->id], ['class' => 'profile-link']);
                },
            ],
            // 'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
