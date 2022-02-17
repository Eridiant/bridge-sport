<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Post */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($model->name) ?></h1>
    <?php if (!empty($model->img)): ?>
        <img src="<?= $model->img; ?>" alt="">
    <?php endif; ?>
    <p><?= $model->description; ?></p>
    <p><?= $model->id; ?></p>
    <p id="quiz" class="link" data-id="<?= $model->id; ?>" data-csrf="">пройти квиз</p>
    <p><?= Yii::$app->formatter->asDate($model->created_at,'php:d.m.y');; ?></p>

</div>
