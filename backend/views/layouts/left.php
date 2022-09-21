<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $content string */



?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (true): ?>
                    <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                <?php endif; ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username; ?></p>
                <p><?= Yii::$app->user->getId(); ?></p>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Главная', 'icon' => 'home', 'url' => ['/site/index']],
                    [
                        'label' => 'Пользователи',
                        'icon' => 'home',
                        'url' => ['#'],
                        'items' => [
                            ['label' => 'Пользователи', 'icon' => 'home', 'url' => ['/user/index']],
                            ['label' => 'Сообщения', 'icon' => 'home', 'url' => ['/message/index']],
                        ],
                    ],
                    [
                        'label' => 'Посты',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Категории', 'icon' => 'home', 'url' => ['/category/index']],
                            ['label' => 'Атрибуты', 'icon' => 'home', 'url' => ['/taxonomy/index']],
                            ['label' => 'Новости', 'icon' => 'home', 'url' => ['/post/index']],
                        ],
                    ],
                    [
                        'label' => 'Опросы',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Опросы', 'icon' => 'home', 'url' => ['/survey/index']],
                            ['label' => 'Edit', 'icon' => 'home', 'url' => ['/quiz/edit']],
                            ['label' => 'Quiz', 'icon' => 'home', 'url' => ['/survey/quiz']],
                            ['label' => 'Ответ', 'icon' => 'home', 'url' => ['/answer/index']],
                        ],
                    ],
                    ['label' => 'Обновления', 'icon' => 'dashboard', 'url' => ['/migrate/index']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Логи',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Логи доступа', 'icon' => 'file-code-o', 'url' => ['/log/index'],],
                            ['label' => 'Логи ошибок', 'icon' => 'dashboard', 'url' => ['/log/err'],],
                        ],
                    ],
                    [
                        'label' => 'Разработка',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['../gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['../debug'],],
                            ['label' => 'Gii admin', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug admin', 'icon' => 'dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
