<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Quiz */

$this->title = 'Update Quiz: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
