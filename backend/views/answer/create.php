<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Answer */

$this->title = 'Create Answer';
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
