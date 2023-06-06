<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use backend\models\Taxonomy;


/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
// var_dump('<pre>');
// var_dump(\backend\models\Post::find()->where(['id' => $model->parent_id])->select(['name'])->one()->name);
// var_dump('</pre>');
// die;

// $this->registerJs('/js/html2canvas.min.js', View::POS_HEAD); 
// $this->registerJs('/js/iframe2image.min.js', View::POS_HEAD); 

?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'category_id')->dropDownList(\backend\models\Category::find()->select(['name', 'id'])->indexBy('id')->column()) ?>

        <?php if (\backend\models\Post::find()->where(['id' => $model->parent_id])->exists()): ?>
            <h3><span>продолжение: </span><?= \backend\models\Post::find()->where(['id' => $model->parent_id])->select(['name'])->one()->name; ?></h3>
        <?php endif; ?>
        
        <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'thread_id')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'name', ['inputOptions' => ['class' => 'form-control name']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'slug', ['inputOptions' => ['class' => 'form-control slug']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'preview')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'text')->widget(CKEditor::className(),[
            'editorOptions' => [
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
            ],
        ]);?>

        <hr>
        <h4>Загрузить изображение</h4>
        <div class="row">
            <div class="col-xs-4">
                <?= $form->field($model, 'img')->fileInput() ?>
            </div>
            <div class="col-xs-8">
                <?= $form->field($model, 'alt')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <?= $form->field($model, 'image_header')->checkbox() ?>
        <hr>
        <!-- <?//= $form->field($model, 'dial')->textInput(['maxlength' => true]) ?>

        <hr> -->
        <h4>добавить сдачу с BBO</h4>
        <?= $form->field($model, 'frame')->textInput() ?>
        <?= $form->field($model, 'iframeAlt')->textInput() ?>
        <div class="wrapper-form">
            <?= $form->field($model, 'onlyImg')->checkbox() ?>
            <?= $form->field($model, 'iframeHide')->checkbox() ?>
            <?= $form->field($model, 'previews')->checkbox() ?>
        </div>

        <hr>

        <h4>добавить видео с Youtube</h4>
        <?= $form->field($model, 'youtubeFields')->textInput() ?>
        <?= $form->field($model, 'youtubeAlt')->textInput() ?>
        <?= $form->field($model, 'hide')->checkbox() ?>
        <hr>

        <?= $form->field($model, 'taxonomiesArray')->checkboxList(Taxonomy::find()->select(['label', 'id'])->indexBy('id')->column()) ?>
        <hr>
        <h2>Блок СЕО</h2>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

        <div class="wrapper-form">

            <?= $form->field($model, 'indexing')->dropDownList([
                    '0'=>'Не индексировать',
                    '1'=>'Исключить из индексации',
                    '4'=>'Подготовка индексации',
                    '5'=>'Индексировать'
            ]) ?>

            <?= $form->field($model, 'priority')->dropDownList([
                    '1'=>'1',
                    '2'=>'2',
                    '3'=>'3',
                    '4'=>'4',
                    '5'=>'5',
                    '6'=>'6',
                    '7'=>'7',
                    '8'=>'8',
                    '9'=>'9'
            ]) ?>

            <?= $form->field($model, 'changefreq')->dropDownList([
                    'always'=>'always',
                    'hourly'=>'hourly',
                    'daily'=>'daily',
                    'weekly'=>'weekly',
                    'monthly'=>'monthly',
                    'yearly'=>'yearly',
                    'never'=>'never'
            ]) ?>

            <?= $form->field($model, 'status')->dropDownList([
                    '0'=>'Скрыта',
                    '6'=>'Не отображать в ленте новостей',
                    '9'=>'Временно не отображать',
                    '10'=>'Доступна',
            ]) ?>

            <?= $form->field($model, 'comments_hide')->dropDownList([
                    '0'=>'Доступны',
                    '1'=>'Скрыты',
                    // '2'=>'Доступ ограничен',
            ]) ?>

        </div>

        <hr>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>
    <div id="ifr" class="form-iframe"></div>

</div>

