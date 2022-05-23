<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логи доступа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-user-ip-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'ip',
                'value' => function (StatUserIp $model) {
                    return long2ip($model->ip);
                },
            ],
            'url:url',
            'ref',
            'lang_choose',
            'lang_all',
            'device',
            'created_at',
            // [
            //     'attribute' => 'created_at',
            //     'value' => function (StatUserIp $model) {
            //         return date("Y-m-d H:i:s", $model->created_at);
            //     },
            // ],
        ],
    ]); ?>


</div>
