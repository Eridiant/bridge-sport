<?php

namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use frontend\models\StatUserIp;
use frontend\models\ErrorLog;

/**
 * Site controller
 */
class AppController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    protected function setMeta($title = null, $description = null, $keywords = null, $type = null, $image = null, $secure_url = null)
    {
        $this->view->title = $title ?: Yii::$app->params['defaultTitle'];
        // $this->view->registerMetaTag(['name' => 'keywords', 'content' => "$keywords"]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $description ?: Yii::$app->params['defaultDescription']]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords ?: Yii::$app->params['defaultKeywords']]);
        $this->view->registerMetaTag(['name' => 'og:title', 'content' => $title ?: Yii::$app->params['defaultTitle']]);
        $this->view->registerMetaTag(['name' => 'og:type', 'content' => $type ?: Yii::$app->params['defaultType']]);
        $this->view->registerMetaTag(['name' => 'og:description', 'content' => $description ?: Yii::$app->params['defaultDescription']]);

        $this->view->registerMetaTag(['name' => 'og:image', 'content' => $image ?: Yii::$app->params['defaultImage']]);
        $this->view->registerMetaTag(['name' => 'og:image:secure_url', 'content' => $secure_url ?: Yii::$app->params['defaultImageUrl']]);
        $this->view->registerMetaTag(['name' => 'og:image:type', 'content' => "image/jpeg"]);
        $this->view->registerMetaTag(['name' => 'og:image:width', 'content' => 1200]);
        $this->view->registerMetaTag(['name' => 'og:image:height', 'content' => 630]);
    }

    public function beforeAction($action)
    {
        Yii::$app->view->params['aside'] = true;

        $request = Yii::$app->request;

        $ip = $request->userIP;

        if ($ip === '185.28.110.65' || $ip === '127.0.0.1') {
            return parent::beforeAction($action);
        }

        $ip = inet_pton($request->userIP);

        try {
            $userSt = new StatUserIp();
            $userSt->ip = $ip;

            if (($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
                $userSt->lang_all = $list;
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
            $this->errLog('except_error', $exception->getMessage());
        }
        return parent::beforeAction($action);
    }

    private function errLog($err, $data)
    {
        $error = new ErrorLog();

        try {
            $error->name = $err;
            $error->error = serialize($data);

            if (!$error->save()) {
                echo 'error';
                // var_dump($error->getErrors());
            }

        }
        catch (\yii\db\Exception $exception) {
            echo 'error';
            // var_dump($exception->getMessage());
            
        }
    }
}

