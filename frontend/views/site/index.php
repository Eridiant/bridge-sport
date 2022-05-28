<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Bridge sport';

?>
<div class="main-wrapper">
    <p>

    </p>
    <?php foreach ($model as $m): ?>
        <div class="news-wrapper">
            <div class="news-img <?= $m->taxonomies[0]->label; ?>">
                <picture>
                    <?php if (empty($m->img)): ?>
                        <img src="/images/dummy/<?= $m->category_id; ?>.jpg" alt="" class="news-img">
                    <?php else: ?>
                        <img src="/images/post/<?= $m->img; ?>" alt="" class="news-img">
                    <?php endif; ?>
                </picture>
            </div>
            <div class="news-inner">
                <div class="news-header">
                <p><?= $m->category->name; ?></p>
                    <p>
                        <?php if ($m->taxonomies): ?>
                            <?php foreach ($m->taxonomies as $taxonomy): ?>
                                <span><?= $taxonomy->label; ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </p>
                </div>
                <h2 class="title"><?= $m->name; ?></h2>
                <p class="news-desc"><?= $m->preview; ?></p>
                <div class="news-footer">
                    <a href="<?= Url::to(['/post', 'id' => $m->id]) ?>">
                        читать больше
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
