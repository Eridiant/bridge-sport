<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stat User Ips';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-user-ip-index">

    <p>
        <?= Html::a('Create Stat User Ip', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'ip6',
                'value' => function ($model) {
                    return inet_ntop($model->ip6);
                },
            ],
            [
                'attribute' => 'ip',
                'value' => function ($model) {
                    return long2ip($model->ip);
                },
            ],
            'status',
            'url:url',
            'ref',
            'lang_choose',
            'lang_all',
            'device',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date("Y-m-d H:i:s", $model->created_at);
                },
            ],
        ],
    ]); ?>


</div>
