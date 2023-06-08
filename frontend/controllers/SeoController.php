<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Post;
use frontend\class\IsBot;
use frontend\models\StatUserIp;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;



class SeoController extends Controller
{

    public function afterAction($action, $result)
    {

        // Yii::$app->view->params['aside'] = true;

        $request = Yii::$app->request;

        $ip = $request->userIP;

        if (($ip > '185.28.110.0' && $ip < '185.28.110.255') || $ip === '127.0.0.1') {
            return parent::afterAction($action, $result);
        }

        $ip = ip2long($request->userIP);

        $ip6 = inet_pton($request->userIP);

        try {
            $userSt = new StatUserIp();
            $userSt->ip = $ip;
            $userSt->ip6 = $ip6;
            $userSt->status = Yii::$app->response->statusCode;

            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $userSt->lang_all = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            }

            if (isset($_SERVER['HTTP_REFERER'])) {
                $userSt->ref = $_SERVER['HTTP_REFERER'];
            }

            $userSt->url = $request->pathInfo;
            $userSt->device = trim($_SERVER['HTTP_USER_AGENT']);
            $userSt->lang_choose = Yii::$app->language;

            if (!$userSt->save()) {
                // $this->errLog('save_error', $userSt->getErrors());
                $this->errLog('save_error', $userSt->errors);
            }

        }
        catch (\yii\db\Exception $exception) {
            var_dump('ex');
            
            $this->errLog('except_error', $exception->getMessage());
        }

        return parent::afterAction($action, $result);
    }

    public function actionIndex()
    {
        $host = Yii::$app->request->hostInfo;

        $indexing = IsBot::isGoogle() ? 3 : 4;

        $posts = Post::find()
                ->where(['>', 'indexing', $indexing])
                ->andWhere(['>', 'status', 8])
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