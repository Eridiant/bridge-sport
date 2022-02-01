<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <p>
        <?= Html::a('Создать корнеую категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'parent_id',
            'name',
            // 'slug',
            // 'keywords',
            //'description:ntext',
            //'active',
            //'deleted_at',
            [
                'label' => 'Добавить статью',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('Добавить', ['/post/create', 'id' => $model->id], ['class' => 'profile-link']);
                },
            ],
            [
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('Подкат', ['/category/create', 'id' => $model->id], ['class' => 'profile-link']);
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, \backend\models\Category $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
