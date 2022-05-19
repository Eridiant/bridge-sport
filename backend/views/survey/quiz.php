<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\models\Quiz;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quiz';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-index">

    <p>
        <?= Html::a('Create Survey', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'name',
            'slug',
            // 'img',
            //'keywords',
            //'preview:ntext',
            //'description:ntext',
            // 'type',
            [
                'label' => 'Добавить вопрос',
                'format' => 'raw',
                'value' => function($model){
                    if (Quiz::find()->where(['survey_id' => $model->id])->count() == 0) {
                        return Html::a('Создать', ['/quiz/create', 'id' => $model->id], ['class' => 'profile-link']);
                    }
                    return Html::a('Редактировать', ['/quiz/edit', 'id' => $model->id], ['class' => 'profile-link']);
                },
            ],
            //'access',
            //'active',
            //'created_at',
            //'updated_at',
            //'deleted_at',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, \backend\models\Survey $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
