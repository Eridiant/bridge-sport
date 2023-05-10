<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\stm\StmSystem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="stm-system-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'name', ['inputOptions' => ['class' => 'form-control name']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug', ['inputOptions' => ['class' => 'form-control slug']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'hidden')->textInput() ?>

    <?= $form->field($model, 'edit')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
