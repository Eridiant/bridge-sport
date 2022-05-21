<?php
// var_dump('<pre>');
// var_dump(Yii::$app->user->identity);
// var_dump('</pre>');
// die;

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
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Обновления', 'icon' => 'dashboard', 'url' => ['/migrate/index']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
