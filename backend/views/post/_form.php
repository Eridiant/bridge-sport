<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use backend\models\Taxonomy;


/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
// var_dump('<pre>');
// var_dump($model);
// var_dump('</pre>');
// die;

?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(\backend\models\Category::find()->select(['name', 'id'])->indexBy('id')->column()) ?>

    <?= $form->field($model, 'name', ['inputOptions' => ['class' => 'form-control name']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug', ['inputOptions' => ['class' => 'form-control slug']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preview')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]);?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <div class="wrapper-form">

        <?= $form->field($model, 'indexing')->dropDownList([
                '0'=>'Не индексировать',
                '1'=>'Индексировать'
        ]) ?>

        <?= $form->field($model, 'active')->dropDownList([
                '0'=>'Скрыта',
                '1'=>'Доступна',
                // '2'=>'Доступ ограничен',
        ]) ?>

    </div>

    <?= $form->field($model, 'taxonomiesArray')->checkboxList(Taxonomy::find()->select(['label', 'id'])->indexBy('id')->column()) ?>

    <?= $form->field($model, 'author_id')->hiddenInput()->label(false) ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <?//= $form->field($model, 'updated_at')->textInput() ?>

    <?//= $form->field($model, 'deleted_at')->textInput() ?>

    <?php

    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

