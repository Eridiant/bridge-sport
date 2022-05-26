<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Bridge sport';
?>
<div class="main-wrapper">
    <p>
        <a href="<?= Url::to(['/site/contact']) ?>"><?= Url::to(['/site/contact']) ?></a>
    </p>
    <?php foreach ($model as $m): ?>
        <div class="news-wrapper">
            <?php if (empty($m->img)): ?>
                <div class="news-img">
                    <picture>
                        <img src="/images/dummy/<?= $m->category_id; ?>.jpg" alt="" class="news-img">
                    </picture>
                </div>
            <?php else: ?>
                <img src="/images/post/<?= $m->img; ?>" alt="">
            <?php endif; ?>
            <div class="news-inner">
                <h2 class="title"><?= $m->name; ?></h2>
                <p><?= $m->preview; ?></p>
                <p><?php 
                // var_dump('<pre>');
                // var_dump($m->category_id); 
                // var_dump('</pre>');
                ?></p>
                <div class="news-footer">
                    <a href="<?= Url::to(['/news', 'id' => $m->id]) ?>">
                        читать больше
                    </a>
                    <p><?= $m->created_at; ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
