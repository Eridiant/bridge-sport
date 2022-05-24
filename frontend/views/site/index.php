<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="container">
    <p>
        <a href="<?= Url::to(['/site/contact']) ?>"><?= Url::to(['/site/contact']) ?></a>
    </p>
    <?php foreach ($model as $m): ?>
        <div class="news-wrapper">
            <?php if (empty($m->img)): ?>
                <img src="/images/post/<?= $m->category_id; ?>.jpg" alt="" class="news-img">
            <?php else: ?>
                <img src="/images/post/<?= $m->img; ?>" alt="">
            <?php endif; ?>
            <div class="news-inner">
                <h2><?= $m->name; ?></h2>
                <p><?= $m->preview; ?></p>
                <p><?php 
                // var_dump('<pre>');
                // var_dump($m->category_id); 
                // var_dump('</pre>');
                ?></p>
                <a href="<?= Url::to(['/news', 'id' => $m->id]) ?>">
                    читать больше
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
