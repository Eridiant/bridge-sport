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
            // 'name',
            [
                // 'label' => 'Доступно',
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model) {
                    return "<a href=" . Url::to($model->url, true) . ">{$model->name}</a>";
                }
            ],
            // 'slug',
            // 'url:url',
            //'preview:ntext',
            // 'description:ntext',
            //'img',
            //'dial',
            //'keywords',
            // 'active',
            [
                'label' => 'Доступно',
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => [0 => 'Не доступно', 5 => 'Не отображать', 9 => 'Не отображать', 10 => 'Доступна'],
                // 'filter' => Post::find()->select(['active', 'id'])->indexBy('id')->column(),
                'value' => function($model) {
                    $answer = '';
                    switch ($model->status) {
                        case 5:
                            $answer = 'Не отображать';
                            break;
                        case 9:
                            $answer = 'Временно не отображать';
                            break;
                        case 10:
                            $answer = 'Доступна';
                            break;
                        default:
                            $answer = 'Не доступно';
                            break;
                    }
                    $color = $model->status === 10 ? 'green' : 'red';
                    return "<span class={$color}>{$answer}</span>";
                }
            ],
            [
                'label' => 'Идексация',
                'attribute' => 'indexing',
                'format' => 'raw',
                'filter' => [0 => 'Не инд', 1 => 'Исключить', 4 => 'Подготовка', 5 => 'Инд'],
                // 'filter' => Post::find()->select(['active', 'id'])->indexBy('id')->column(),
                'value' => function($model) {
                    $answer = '';
                    switch ($model->indexing) {
                        case 1:
                            $answer = 'Исключить';
                            break;
                        case 4:
                            $answer = 'Подготовка';
                            break;
                        case 5:
                            $answer = 'Индексировать';
                            break;
                        default:
                            $answer = 'Не инд';
                            break;
                    }
                    $color = $model->indexing === 5 ? 'green' : 'red';
                    return "<span class={$color}>{$answer}</span>";
                }
            ],
            [
                'label'=>'предыдущая',
                'value'=>function($model){
                    return $model->parent_id ? \backend\models\Post::find()->where(['id' => $model->parent_id])->select(['name'])->one()->name : '';
                },
                'contentOptions' => ['class' => 'limit', 'style' => 'max-width: 100px;'],
            ],
            [
                'label' => 'Добавить статью',
                'format' => 'raw',
                'value' => function($model){
                    if (\backend\models\Post::find()->where(['parent_id' => $model->id])->exists()) {
                        return Html::a('Редактировать', ['/post/update', 'id' => \backend\models\Post::find()->where(['parent_id' => $model->id])->one()->id, 'parent' => $model->id], ['class' => 'limit']);
                    }
                    return Html::a('Добавить', ['/post/create', 'id' => $model->category_id, 'parent' => $model->id], ['class' => 'profile-link']);
                },
            ],
            //'author_id',
            //'created_at',
            //'updated_at',
            //'deleted_at',
            //'parent_id',
            //'comments_status',
            //'survey_id',
            //'comments_hide',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, \backend\models\Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
