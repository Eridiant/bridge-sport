<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <?php foreach ($model as $model): ?>
        <div class="news-wrapper">
            <img src="/images/dummy/1.jpg" alt="" class="news-img">
            <div class="news-inner">
                <h2><?= $model->name ?></h2>
                <p><?= $model->preview; ?></p>
                <a href="<?= Url::to(['survey/view', 'slug' => $model->slug]) ?>">
                    пройти опрос
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
