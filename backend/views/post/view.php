<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <p>
        <?php if ($model->parent_id): ?>
            <?= Html::a('Редактировать предыдущую статью', ['update', 'id' => $model->parent_id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (\backend\models\Post::find()->where(['parent_id' => $model->id])->exists()): ?>
            <?= Html::a('Редактировать следующую статью', ['update', 'id' => \backend\models\Post::find()->where(['parent_id' => $model->id])->one()->id], ['class' => 'btn btn-primary']) ?>
        <?php else: ?>
            <?= Html::a('Добавить следоащую статью', ['/post/create', 'id' => $model->category_id, 'parent' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'parent_id',
            'name',
            'url:ntext',
            'slug',
            'preview:ntext',
            'text:ntext',
            'img',
            'dial',
            // 'iframe',
            'indexing',
            'title',
            'description:ntext',
            'keywords',
            'status',
            'author_id',
            'published_at',
            'created_at',
            'updated_at',
            'deleted_at',
        ],
    ]) ?>

</div>
