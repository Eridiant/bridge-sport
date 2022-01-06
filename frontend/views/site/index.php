<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?php foreach ($model as $m): ?>
        <div>
            <h1><?= $m->name; ?></h1>
            <p><?= $m->description; ?></p>
            <a href="<?= Url::toRoute(['/news', 'slug' => $m->slug]) ?>">читать больше</a>
        </div>
    <?php endforeach; ?>
</div>
