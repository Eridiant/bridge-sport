<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<h2>Результат</h2>
<a href="<?= Url::to(['survey/view', 'slug' => $model->slug]) ?>">перейти к обсуждению</a>
