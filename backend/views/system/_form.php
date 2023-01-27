<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\system\System */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?//= $form->field($model, 'user_id')->textInput() ?> -->

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'name', ['inputOptions' => ['class' => 'form-control name']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug', ['inputOptions' => ['class' => 'form-control slug']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'hidden')->dropDownList([
                '0'=>'Отображать',
                '1'=>'Скрывать'
        ]) ?>

    <!-- <?//= $form->field($model, 'edit')->dropDownList([
                // '0'=>'Не индексировать',
                // '1'=>'Индексировать'
        // ]) ?> -->

    <!-- <?//= $form->field($model, 'updated_at')->textInput() ?> -->

    <!-- <?//= $form->field($model, 'created_at')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
