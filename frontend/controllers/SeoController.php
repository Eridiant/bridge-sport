<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Post;
use frontend\class\IsBot;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;



class SeoController extends Controller
{

    public function actionIndex()
    {
        $host = Yii::$app->request->hostInfo;

        $indexing = IsBot::isGoogle() ? 4 : 5;

        $posts = Post::find()
                ->where(['>', 'indexing', $indexing])
                ->select(['url', 'priority', 'changefreq', 'updated_at'])
                ->all();

        header("Content-type: text/xml");

        return $this->renderPartial('index', compact('posts', 'host'));
    }

    public function actionRobots()
    {
        $host = Yii::$app->request->hostInfo;

        $posts = Post::find()
                ->where(['indexing' => 1])
                ->select(['url'])
                ->all();


        header('Content-Type: text/plain');

        return $this->renderPartial('robots', compact('host', 'posts'));
    }
}