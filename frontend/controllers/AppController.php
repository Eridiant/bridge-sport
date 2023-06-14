<?php

namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use frontend\models\StatUserIp;
use frontend\models\ErrorLog;
use yii\helpers\Url;

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

    protected function setMeta($title = null, $description = null, $keywords = null, $image = null, $type = null)
    {
        if (is_null($image)) {
            $secure_url = null;
        } else {
            $image = "images/{$image}-1200x630.jpg";
            $secure_url = Url::to("@web/{$image}", true);
            $image = "/{$image}";
        }

        $this->view->title = $title ?: Yii::$app->params['defaultTitle'];

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
        // $this->setMeta();
        return parent::beforeAction($action);
    }

    // public function afterAction($action, $result)
    // {
    //     $result = parent::afterAction($action, $result);
        // your custom code here
    //     return $result;
    // }

    public function init()
    {
        parent::init();
        
        // Attach the event handler to the afterAction event
        $this->on(Controller::EVENT_AFTER_ACTION, [$this, 'saveIp']);
    }

    protected function checkingBots($url)
    {
        
        $suspicion = 0;
        $multiplier = 1;

        if (Yii::$app->response->statusCode > 399) {
            $multiplier++;
        }

        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $suspicion += 2;
        }
        if (!isset($_SERVER['REDIRECT_REDIRECT_GEOIP_COUNTRY_CODE'])) {
            $suspicion++;
        }
        if (!isset($_SERVER['REDIRECT_REDIRECT_GEOIP_REGION_NAME'])) {
            $suspicion++;
        }
        if (!isset($_SERVER['REDIRECT_REDIRECT_GEOIP_CITY'])) {
            $suspicion++;
        }
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            $suspicion += 2;
        }

        $signatures = ['.dist', '.env', '.zip', '.tar', '.php', '.json', '.xml', '.xsd', '.txt', '.js'];
        foreach ($signatures as $signature) {
            if (strpos($url, $signature)) {

                $suspicion++;
                $multiplier++;
                return $suspicion * $multiplier;
            }
        }
        return $suspicion * $multiplier;
    }

    protected function saveIp()
    {
        
        $request = Yii::$app->request;

        $ip = $request->userIP;

        if (($ip > '185.28.110.0' && $ip < '185.28.110.255') || $ip === '127.0.0.2') {
            return;
        }

        $ip = ip2long($request->userIP);

        $ip6 = inet_pton($request->userIP);

        try {
            $userSt = new StatUserIp();
            $userSt->ip = $ip;
            $userSt->ip6 = $ip6;
            $userSt->status = Yii::$app->response->statusCode;

            $userSt->lang_all = substr(htmlspecialchars(strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null)), 0, 125);

            $userSt->ref = substr(htmlspecialchars($_SERVER['HTTP_REFERER'] ?? null), 0, 255);
            $userSt->country_name = substr(htmlspecialchars($_SERVER['REDIRECT_REDIRECT_GEOIP_COUNTRY_NAME'] ?? null), 0, 255);
            $userSt->region = substr(htmlspecialchars($_SERVER['REDIRECT_REDIRECT_GEOIP_REGION_NAME'] ?? null), 0, 255);
            $userSt->city = substr(htmlspecialchars($_SERVER['REDIRECT_REDIRECT_GEOIP_CITY'] ?? null), 0, 255);
            $userSt->country_code = substr(htmlspecialchars($_SERVER['REDIRECT_REDIRECT_GEOIP_COUNTRY_CODE'] ?? null), 0, 10);

            $userSt->url = $request->pathInfo;
            $userSt->bot = $this->checkingBots($request->pathInfo);
            $userSt->device = substr(htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? null), 0, 255);
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

