<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Post */

$this->title = $model->name;

?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($model->img)): ?>
        <img src="<?= $model->img; ?>" alt="">
    <?php endif; ?>

    <p><?= $model->text; ?></p>

    <?php if (!empty($model->iframe)): ?>
        <iframe src="<?= $model->iframe; ?>" frameborder="0"></iframe>
    <?php endif; ?>

</div>
