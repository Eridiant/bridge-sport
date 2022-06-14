<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Post */

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

    <?php if (!empty($model->iframe)): ?>
        <iframe src="<?= $model->iframe->frame; ?>" frameborder="0"></iframe>
    <?php endif; ?>

</div>
