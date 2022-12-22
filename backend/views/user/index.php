<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="users" class="user-index">

    <p>
        <?= Html::a('exect user', ['exect'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            //'email:email',
            // 'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            [
                'label' => 'Роль',
                'attribute' => 'name',
                'format' => 'raw',
                // 'contentOptions' => ['data-set' => $model->id],
                // 'filter' => [0 => 'Не доступно', 1 => 'Доступно'],
                'value' => function($model) {
                    // return $model->can('admin');
                    return "<div class='user' data-id=\"{$model->id}\">" . Html::dropDownList('name', $model->role->item_name ?? 'guest', ArrayHelper::getColumn(Yii::$app->authManager->getItems('1'), 'name')) . "</div>";
                    // return $model->role->item_name ?? 'guest';
                    // return Yii::$app->authManager->getRolesByUser($model->id)[0];
                }
            ],
            // [
            //     Yii::$app->authManager->getItems('1')
            // ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
