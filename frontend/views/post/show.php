<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Post */
// var_dump('<pre>');
// var_dump($model);
// var_dump('</pre>');
// die;

?>

<script>
    var srv = <?= json_encode($survey); ?>;
    var prnt = <?= json_encode($parent); ?>;
    var nswr = <?= json_encode($answer); ?>;
</script>

<div class="post-view">

    <div class="post-img">
        <picture>
            <?php if (!empty($model->image->path) && $model->image_header): ?>
                <?= Yii::$app->imageComponent->image($model->image); ?>
            <?php endif; ?>
        </picture>
    </div>

    <h1><?= $model->name ?></h1>

    <?php if (!empty($model->img)): ?>
        <img src="<?= $model->img; ?>" alt="">
    <?php endif; ?>

    <p><?= $model->text; ?></p>

    <?php if (!empty($model->youtube) && !$model->youtube->hide): ?>
        <div id="post-youtube" class="post-youtube active" data-youtube="<?= $model->youtube->key; ?>">
            <picture>
                <?php if (!empty($model->youtube->image)): ?>
                    <?= Yii::$app->imageComponent->image($model->youtube->image); ?>
                <?php else: ?>
                    <source type="image/jpeg" srcset="/images/dummy/youtube-mb.jpg" media="(max-width: 480px)">
                    <img src="/images/dummy/youtube.jpg" alt="">
                <?php endif; ?>
            </picture>
            <svg class="post-youtube-svg" width="68" height="48"><use xlink:href="/images/icons.svg#ytp"></use></svg>
        </div>
    <?php endif; ?>
    <?php if (!empty($model->iframe) && !$model->iframe->hide): ?>
        <div <?= !$model->iframe->only_img ? 'id="post-iframe"' : ''; ?> class="post-iframe <?= !$model->iframe->only_img ? ' active' : ''; ?>" data-iframe="<?= !$model->iframe->only_img ? $model->iframe->frame : ''; ?>" data-text="<?= !$model->iframe->only_img ? 'кликните для взаимодействия' : ''; ?>">
            <picture>
                <?php if (!empty($model->iframe->image)): ?>
                    <?= Yii::$app->imageComponent->image($model->iframe->image); ?>
                <?php else: ?>
                    <source type="image/jpeg" srcset="/images/dummy/youtube-mb.jpg" media="(max-width: 480px)">
                    <img src="/images/dummy/youtube.jpg" alt="">
                <?php endif; ?>
            </picture>
        </div>
    <?php endif; ?>

    <?php if (!empty($model->survey)): ?>
        <form action="/">
            <div id="aski" class="post-survey"></div>
            <button id="survey" class="custom-btn btn-8" type="button"><span>пройти квиз</span></button>
        </form>
    <?php endif; ?>

    <div class="post-link">
        <div class="post-row">
            <?php if (isset($model->thread_id)): ?>
                <?= Html::a(\backend\models\Post::find()->where(['id' => $model->thread_id])->one()->name, ['/post', 'id' => $model->thread_id], ['class' => 'success']) ?>
            <?php endif; ?>
        </div>
        <div class="post-row">
            <?php if (isset($model->parent_id)): ?>
                <?= Html::a("&xlarr;" . \backend\models\Post::find()->where(['id' => $model->parent_id])->one()->name, ['/post', 'id' => $model->parent_id], ['class' => 'successs']) ?> |
            <?php endif; ?>
            <?php if (\backend\models\Post::find()->where(['parent_id' => $model->id])->exists()): ?>
                <?= Html::a(\backend\models\Post::find()->where(['parent_id' => $model->id])->one()->name . "&xrarr;", ['/post', 'id' => \backend\models\Post::find()->where(['parent_id' => $model->id])->one()->id], ['class' => 'success']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->render('_discussion', ['model' => $model]); ?>

