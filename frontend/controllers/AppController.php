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

    public function beforeAction($action)
    {
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

