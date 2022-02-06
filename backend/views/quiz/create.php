<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Quiz */

$this->title = 'Create Quiz';
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
