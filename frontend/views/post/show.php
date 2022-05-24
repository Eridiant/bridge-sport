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
    <iframe src="https://www.bridgebase.com/tools/handviewer.html?b=1&d=n&v=-&n=sK853h6532d876cKT&e=sAJ4hAQJTdAQ954cA&s=sQT2hK98dKJT3c653&w=s976h74d2cQJ98742&a=p5Cppp&p={%3Cp%3ESIRIUS%20CUP%20IMP%202022,%20%D1%82%D1%83%D1%80%D0%BD%D0%B8%D1%80#3%20%D0%9F%D0%B0%D1%80%D0%BD%D1%8B%D0%B9%20%D1%82%D1%83%D1%80%D0%BD%D0%B8%D1%80%20#%2021d06.%20SESSION%201%3C/p%3E%3Cp%3E%D0%9A%D1%83%D0%B7%D0%BD%D0%B5%D1%86%D0%BE%D0%B2%20%D0%94%D0%BC%D0%B8%D1%82%D1%80%D0%B8%D0%B9-%D0%A5%D0%B2%D0%B5%D0%BD%D1%8C%20%D0%95%D0%B2%D0%B3%D0%B5%D0%BD%D0%B8%D0%B9%20VS%20%D0%A0%D0%B0%D1%85%D0%BC%D0%B0%D0%BD%D0%B8%20%D0%94%D0%B8%D0%B0%D0%BD%D0%B0-%D0%9C%D0%BE%D0%B3%D1%83%D1%87%D0%B5%D0%B2%D0%B0%20%D0%90%D0%BD%D0%BD%D0%B0%3C/p%3E}" frameborder="0"></iframe>

</div>
