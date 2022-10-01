<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MessageReply */

$this->title = 'Create Message Reply';
$this->params['breadcrumbs'][] = ['label' => 'Message Replies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-reply-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
