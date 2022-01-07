<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Post */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($model->img)): ?>
        pkfgbpltw 
    <?php endif; ?>

    <p><?= $model->description; ?></p>

    <?//= DetailView::widget([
        // 'model' => $model,
        // 'attributes' => [
        //     'id',
        //     'category_id',
        //     'name',
        //     'url:ntext',
        //     'slug',
        //     'preview:ntext',
        //     'description:ntext',
        //     'img',
        //     'dial',
        //     'keywords',
        //     'active',
        //     'author_id',
        //     'created_at',
        //     'updated_at',
        //     'deleted_at',
        // ],
    // ]) 
    ?>

</div>
