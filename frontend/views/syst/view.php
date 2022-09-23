<?php

use yii\helpers\Html;
use common\components\SystWidget;

?>
<div class="title">
    <?= $model->name; ?>
</div>
<div class="desc">
    <?= $model->description; ?>
</div>
<aside class="accordion">
    <?= SystWidget::widget(['tpl' => 'view', 'id' => $model->id]); ?>
</aside>
