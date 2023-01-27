<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="system-index">

    <h1>Системы торговли</h1>

    <?php foreach ($model as $item): ?>
        <h2><a href="<?= $item->slug; ?>"><?= $item->name; ?></a></h2>
    <?php endforeach; ?>

</div>
