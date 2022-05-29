<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php if (!Yii::$app->user->isGuest): ?>

<!-- ------Admin-panel----------- -->
<div class="admin">
    <a href="<?= Url::toRoute('/site/logout') ?>" class="admin-item">logout</a>
    <a href="<?= Url::toRoute('/admin') ?>" class="admin-item">admin-panel</a>
</div>

<!-- ------Admin-panel-end----------- -->
<?php endif; ?>

<?php require_once('template-header.php'); ?>

<div class="main">
    <div class="container main-container" style="max-width: 1600px; margin-left: auto; margin-right: auto">
        <?php require_once('template-aside.php'); ?>
        <main role="main">
            <?= $content ?>
        </main>
    </div>
</div>

<?php require_once('template-footer.php'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
