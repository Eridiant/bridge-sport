<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SysAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
    ];
    public $js = [
        'js/main.js',
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap4\BootstrapAsset',
    ];
    // public function init()
    // {
    //     parent::init();
    //     // resetting BootstrapAsset to not load own css files
    //     \Yii::$app->assetManager->bundles['yii\\bootstrap4\\BootstrapAsset'] = [
    //         'css' => [],
    //         'js' => []
    //     ];
    // }
}
