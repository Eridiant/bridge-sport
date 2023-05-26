<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\poll\Poll $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="poll-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_id')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'save_result')->checkbox() ?>

    <?= $form->field($model, 'save_response')->checkbox() ?>

    <?= $form->field($model, 'show_result')->checkbox() ?>

    <?= $form->field($model, 'show_only_user_result')->checkbox() ?>

    <!-- <?//= $form->field($model, 'show_grade')->checkbox() ?> -->

    <?= $form->field($model, 'allow_guest')->checkbox() ?>

    <?= $form->field($model, 'save_guest_result')->checkbox() ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'poll_close')->checkbox() ?>

    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
