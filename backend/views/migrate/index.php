<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Migrate';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migrate-index">
    <p>
        <?= Html::a('Migrate up', ['/migrate/up'], ['class' => 'btn btn-success', 'id' => 'up']) ?>
        <?= Html::a('Migrate down', ['/migrate/down'], ['class' => 'btn btn-danger', 'id' => 'down']) ?>
    </p>
    <div class="migrate-area"></div>
</div>