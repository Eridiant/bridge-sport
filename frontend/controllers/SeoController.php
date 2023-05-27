<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Post;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;



class SeoController extends Controller
{

    public function actionIndex()
    {
        $host = Yii::$app->request->hostInfo;

        $indexing = 4;

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

        header("Content-type: text/txt");

        return $this->renderPartial('index', compact('host'));
    }
}