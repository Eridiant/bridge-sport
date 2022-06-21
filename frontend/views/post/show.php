<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Post */
// var_dump('<pre>');
// var_dump($model->youtube->image);
// var_dump('</pre>');
// die;

?>
<div class="post-view">

    <h1><?= Html::encode($model->name) ?></h1>

    <div class="post-img">
        <picture>
            <?php if (!empty($model->image->path)): ?>
                <?= Yii::$app->imageComponent->image($model->image); ?>
            <?php endif; ?>
        </picture>
    </div>

    <?php if (!empty($model->img)): ?>
        <img src="<?= $model->img; ?>" alt="">
    <?php endif; ?>

    <p><?= $model->text; ?></p>

    <?php if (!empty($model->youtube)): ?>
        <div id="post-youtube" class="post-youtube" data-youtube="<?= $model->youtube->key; ?>">
            <picture>
                <?php if (!empty($model->youtube->image)): ?>
                    <?= Yii::$app->imageComponent->image($model->youtube->image); ?>
                <?php else: ?>
                    <source type="image/jpeg" srcset="/images/dummy/youtube-mb.jpg" media="(max-width: 480px)">
                    <img src="/images/dummy/youtube.jpg" alt="">
                <?php endif; ?>
            </picture>
        </div>
        <!-- <img src="https://i.ytimg.com/vi/<?//= $model->youtube->key; ?>/maxresdefault.jpg" alt=""> -->
        <!-- <iframe width="892" height="502" src="https://www.youtube.com/embed/<?//= $model->youtube->key; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
    <?php endif; ?>
    <?php if (!empty($model->iframe)): ?>
        <div id="post-iframe" class="post-iframe">
            <iframe src="<?= $model->iframe->frame; ?>"></iframe>
        </div>
    <?php endif; ?>
</div>
