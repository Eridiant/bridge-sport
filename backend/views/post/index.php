<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\models\Post;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <p>
        <?= Html::a('Создать новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'category_id',
            [
                'label' => 'Доступно',
                'attribute' => 'category_id',
                'format' => 'text',
                'filter' => Category::find()->select(['name', 'id'])->indexBy('id')->column(),
                // 'value' => function($model) {
                //     return $model->category->name;
                // }
                'value' => 'category.name',
            ],
            // [
            //     'attribute' => 'category_id',
            //     'filter' => Category::find()->select(['name', 'id'])->indexBy('id')->column(),
            //     'value' => 'category.name',
            // ],
            'name',
            'slug',
            // 'url:ntext',
            //'preview:ntext',
            // 'description:ntext',
            //'img',
            //'dial',
            //'keywords',
            // 'active',
            [
                'label' => 'Доступно',
                'attribute' => 'active',
                'format' => 'text',
                'filter' => [0 => 'Не доступно', 1 => 'Доступно'],
                // 'filter' => Post::find()->select(['active', 'id'])->indexBy('id')->column(),
                'value' => function($model) {
                    return $model->active ? 'Доступно' : 'Не доступно';
                }
            ],
            //'author_id',
            //'created_at',
            //'updated_at',
            //'deleted_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, \backend\models\Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
