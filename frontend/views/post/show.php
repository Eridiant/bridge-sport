<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Post */

$this->title = $model->name;

?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($model->img)): ?>
        pkfgbpltw 
    <?php endif; ?>

    <p><?= $model->description; ?></p>

</div>
