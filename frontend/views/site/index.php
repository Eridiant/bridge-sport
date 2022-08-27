<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = 'Bridge sport';
// var_dump('<pre>');
// var_dump($model[0]->image);
// var_dump('</pre>');
// die;

?>
<div class="main-wrapper">
    <?php foreach ($model as $key => $m): ?>
        <div class="news-wrapper">
            <div class="news-img <?= is_null($m->taxonomies) ? $m->taxonomies[0]->label : ''; ?>">
                <a href="<?= Url::to(['/post', 'id' => $m->id]) ?>">
                    <picture>
                        <?php if (!(!empty($m->iframe->preview) && !$m->iframe->hide) && empty($m->image->path)): ?>
                            <img src="/images/dummy/<?= $m->category_id; ?>.jpg" alt="" class="news-img">
                        <?php else: ?>
                            <?php if ($m->iframe && $m->iframe->preview && !$m->iframe->hide): ?>
                                <?= Yii::$app->imageComponent->image($m->iframe->image, 'thumb'); ?>
                            <?php else: ?>
                                <?= Yii::$app->imageComponent->image($m->image, 'thumb'); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </picture>
                </a>
            </div>
            <div class="news-inner">
                <div class="news-header">
                <p><?= $m->category->singular ?? $m->category->name; ?></p>
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
