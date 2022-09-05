<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<header class="nav">
    <div class="container-lg" style="max-width: 1920px; margin-left: auto; margin-right: auto">
        <div class="container" style="max-width: 1600px; margin-left: auto; margin-right: auto">
            <div class="nav-logo">
                <a class="title" href="<?= Url::to('/') ?>">Bridge sport</a>
            </div>
            <nav class="nav-item">
                <a href="<?= Url::to('/') ?>">Главная</a>
                <?php if (Yii::$app->user->isGuest): ?>
                    <?= Html::a('Login',['/site/login']); ?>
                <?php else: ?>
                    <?= Html::a('Logout (' . Yii::$app->user->identity->username . ')',['/site/logout']); ?>
                <?php endif; ?>

            </nav>
            <div class="aside-icon">
                <p>&#8801;</p>
            </div>
        </div>
    </div>
</header>

