<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
// var_dump('<pre>');
// var_dump($dataProvider->getModels());
// var_dump('</pre>');
// die;
// // var_dump($this->q);

$this->title = 'Сообещения требующие подтверждения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            // 'user_id',
            'user.username',
            // 'post_id',
            [
                'attribute' => 'post_id',
                'format' => 'text',
                'value' => 'post.name',
                'contentOptions' =>function ($model){
                    return ['class' => 'limit tooltips m-25', 'style' => 'max-width: 100px;', 'data-tooltip' => $model->post ? $model->post->name : ''];
                },
            ],
            [
                'attribute' => 'message',
                'format' => 'text',
                'contentOptions' =>function ($model){
                    return ['class' => 'show-limit m-40', 'style' => 'max-width: 200px;'];
                },
            ],
            // 'history:ntext',
            // 'show',
            [
                'attribute' => 'Дата',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->created_at);
                }
            ],
            // 'created_at',
            // 'message_id',
            //'updated_at',
            // 'deleted_at',
            [
                'label' => 'Действия',
                'format' => 'raw',
                'value' => function($model){
                    $showAll = Html::a('showAll', ['/message/show-all', 'id' => $model->user_id], ['class' => 'messge']);
                    $delAll = Html::a('delAll', ['/message/delete-all', 'id' => $model->user_id], ['class' => 'messge']);
                    if ($model->message_id) {
                        $del = Html::a('Удалить', ['/message-reply/delete', 'id' => $model->id], ['class' => 'messge']);
                        $show = Html::a('show', ['/message-reply/show', 'id' => $model->id], ['class' => 'messge']);
                        return $del . '|' . $show . '|' . $showAll. '|' . $delAll;
                    }
                    $del = Html::a('Удалить', ['/message/delete', 'id' => $model->id], ['class' => 'messge']);
                    $show = Html::a('show', ['/message/show', 'id' => $model->id], ['class' => 'messge']);
                    return $del . '|' . $show . '|' . $showAll . '|' . $delAll;
                },
            ],
            // [
            //     'class' => ActionColumn::class,
            //     'urlCreator' => function ($action, $model, $key, $index, $column) {
            //         var_dump($key);
                    
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //     }
            // ],
        ],
    ]); ?>


</div>
