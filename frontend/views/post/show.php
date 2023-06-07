<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Post */
// var_dump('<pre>');
// var_dump(isset($model->poll));
// var_dump('</pre>');
// die;

// $this->registerMetaTag([
//     'name' => 'robots',
//     'content' => 'noindex'
// ]);

?>

<script>
    var srv = <?= json_encode($survey); ?>;
    var prnt = <?= json_encode($parent); ?>;
    var nswr = <?= json_encode($answer); ?>;
</script>

<div class="post-view">
    <main>
        <header class="post-img">
            <picture>
                <?php if (!empty($model->image->path) && $model->image_header): ?>
                    <?= Yii::$app->imageComponent->image($model->image); ?>
                <?php endif; ?>
            </picture>
            <h1><?= $model->name ?></h1>
        </header>
        <article>
            <?= $model->text; ?>
        </article>
    </main>
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

    <?php if (is_null($model->poll)): ?>
    <?php elseif (isset($model->poll->pollUsers) || $model->poll->poll_close): ?>
        <?= $this->render('/poll/results', [
            'model' => $model->poll,
        ]) ?>
    <?php elseif ((!Yii::$app->user->isGuest || $model->poll->allow_guest == 1)): ?>
        <div class="poll" data-id=<?= $model->poll->id; ?>>
            <div class="poll-header">
                <?= $model->poll->description; ?>
            </div>
            <?php foreach ($model->poll->pollQuestions as $question): ?>
                <?php if ($question->type == 1): ?>
                    <div class="poll-question" data-id=<?= $question->id; ?>>
                        <p><?= $question->text; ?></p>
                        <?= Html::checkboxList("question-{$question->id}", null, ArrayHelper::map($question->answers, 'id', 'text'), (['class' => 'poll-answer'])) ?>
                    </div>
                <?php elseif ($question->type == 0): ?>
                    <div class="poll-question" data-id=<?= $question->id; ?>>
                        <p><?= $question->text; ?></p>
                        <?= Html::radioList("question-{$question->id}", null, ArrayHelper::map($question->answers, 'id', 'text'), (['class' => 'poll-answer'])) ?>
                    </div>
                <?php else: ?>
                    <div class="poll-question" data-id=<?= $question->id; ?>>
                        <p><?= $question->text; ?></p>
                        <div class="poll-answer">
                            <input type="text" name="" id="" checked>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <button id="poll-submit" class="custom-btn btn-8" type="button"><span>продолжить</span></button>
        </div>
    <?php else: ?>
    <?php endif; ?>

    <div class="post-link">
        <p>Другие стати по теме:</p>
        <div class="post-row">
            <?php if (isset($model->thread_id) && $model->thread_id !== $model->parent_id): ?>
                <?= Html::a(\backend\models\Post::find()->where(['id' => $model->thread_id, 'status' => 10])->one()->name, ['/post', 'id' => $model->thread_id], ['class' => 'success']) ?>
            <?php endif; ?>
        </div>
        <div class="post-row">
            <?php if (isset($model->parent_id)): ?>
                <?= Html::a("&xlarr;" . \backend\models\Post::find()->where(['id' => $model->parent_id, 'status' => 10])->one()->name, ['/post', 'id' => $model->parent_id], ['class' => 'successs']) ?> |
            <?php endif; ?>
            <?php if (\backend\models\Post::find()->where(['parent_id' => $model->id, 'status' => 10])->exists()): ?>
                <?= Html::a(\backend\models\Post::find()->where(['parent_id' => $model->id])->one()->name . "&xrarr;", ['/post', 'id' => \backend\models\Post::find()->where(['parent_id' => $model->id])->one()->id], ['class' => 'success']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if (!$model->comments_hide): ?>
    <?= $this->render('_discussion', ['model' => $model]); ?>
<?php endif; ?>

