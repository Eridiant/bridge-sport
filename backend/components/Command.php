<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\console\Application;

class Command extends Component
{
    public static function execute($action,$params){
        $oldApp = \Yii::$app;
        $newApp = static::getNewApp(static::getConfig());
        $newApp->runAction($action,$params);
        \Yii::$app = $oldApp;
        return true;
    }

    private static function getConfig() {
        $config = require Yii::getAlias('@console/config/main.php');
        $config['components']['db']=\Yii::$app->db;

        return $config;
    }

    private static function getNewApp($config){
        return new Application($config);
    }
}