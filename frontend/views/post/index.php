<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['/site/index'], true)]);

?>
<main class="main-wrapper">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php foreach ($model as $post): ?>
        <article class="news-wrapper">
            <div class="news-img <?= is_null($post->taxonomies) ? $post->taxonomies[0]->label : ''; ?>">
                <picture>
                    <?php if (empty($post->image->url)): ?>
                        <img src="/images/dummy/<?= $post->category_id; ?>.jpg" alt="" class="news-img">
                    <?php else: ?>
                        <img src="/images/post/<?= $post->image->url; ?>" alt="" class="news-img">
                    <?php endif; ?>
                </picture>
            </div>
            <div class="news-inner">
                <div class="news-header">
                <p><?= $post->category->name; ?></p>
                    <p>
                        <?php if ($post->taxonomies): ?>
                            <?php foreach ($post->taxonomies as $taxonomy): ?>
                                <span><?= $taxonomy->label; ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </p>
                </div>
                <h2 class="title"><?= $post->name; ?></h2>
                <p class="news-desc"><?= $post->preview; ?></p>
                <div class="news-footer">
                    <a href="<?= Url::to(['/post', 'id' => $post->id]) ?>">
                        читать больше
                    </a>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</main>