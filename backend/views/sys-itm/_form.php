<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SysItm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-itm-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'syst_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'answer_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'lvl')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
