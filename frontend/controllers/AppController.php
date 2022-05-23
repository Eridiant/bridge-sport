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
        $ip = ip2long($request->userIP);

        if ($ip === 3105648193 || $ip === 2130706433) {
            return parent::beforeAction($action);
        }

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
                $this->errLog('save_error', $userSt->getErrors());
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
            $error->error = $data;

            if (!$error->save()) {
                echo 'error';
            }

        }
        catch (\yii\db\Exception $exception) {
            echo 'error';
        }
    }
}

