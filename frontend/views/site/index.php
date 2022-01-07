<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <p>
        <a href="<?= Url::to(['/site/contact']) ?>"><?= Url::to(['/site/contact']) ?></a>
    </p>
    <?php foreach ($model as $m): ?>
        <div>
            <h1><?= $m->name; ?></h1>
            <p><?= $m->preview; ?></p>
            <a href="<?= Url::to(['/news', 'id' => $m->id]) ?>">читать больше</a>
        </div>
    <?php endforeach; ?>
</div>
