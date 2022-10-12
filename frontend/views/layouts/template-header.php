<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\components\notifications\NotificationsWidget;

?>

<header class="nav">
    <div class="container-lg" style="max-width: 1920px; margin-left: auto; margin-right: auto">
        <div class="container" style="max-width: 1600px; margin-left: auto; margin-right: auto">
            <div class="nav-logo">
                <a class="title" href="<?= Url::to('/') ?>">Bridge sport</a>
            </div>
            <nav class="nav-item">
                <a href="<?= Url::to('/') ?>">Главная</a>
                <span>&#8226;</span>
                <?php if (Yii::$app->user->isGuest): ?>
                    <?= Html::a('Login',['/site/login']); ?>
                <?php else: ?>
                    <?= Html::a('Logout (' . Yii::$app->user->identity->username . ')',['/site/logout']); ?>
                    <a id="notifications" href="javascript:void(0);">
                        <svg width="24" height="24">
                            <use xlink:href="/images/icons.svg#notifications"></use>
                        </svg>
                        <sup><?= NotificationsWidget::widget(['request' => true]); ?></sup>
                    </a>
                    <div class="nav-popup">
                        <?= NotificationsWidget::widget(); ?>
                        <div class="nav-footer">
                            <a class="blank" href="<?= Url::to(['/notifications/index']); ?>">показать все</a>
                        </div>
                    </div>
                <?php endif; ?>

            </nav>
            <div class="aside-icon">
                <p>&#8801;</p>
            </div>
        </div>
    </div>
</header>

