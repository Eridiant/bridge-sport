<?php

namespace backend\controllers;

use Yii;
use backend\components\Command;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Execute Yii2 migrations from folder /console/migrations
 * To migrate, you need log in under the administrator role and go to the url: <your domain>/migrate/
 *
 * This realization can execute only command like "migrate/up". If you need more functionality, please use console.
 *
 * Class MigrationController
 * @package frontend\controllers
 */
class MigrateController extends AppController
{
    /**
     * {@inheritdoc}
     */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'rules' => [
    //                 [
    //                     'actions' => ['login', 'error'],
    //                     'allow' => true,
    //                 ],
    //                 [
    //                     'actions' => ['index', 'up', 'down'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],

    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::class,
    //             'actions' => [
    //                 'delete' => ['POST', 'GET'],
    //             ],
    //         ],
    //     ];
    // }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUp()
    {
        ob_start();
        Command::execute("migrate/up", ['interactive' => false]);
        $output = ob_get_contents();
        ob_end_clean();

        if (empty($output)) {
            $output = 'All migrations are installed!';
        } else {
            $output = $output;
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $output;
    }

    public function actionDown()
    {
        ob_start();
        Command::execute("migrate/down", ['interactive' => false]);
        $output = ob_get_contents();
        ob_end_clean();

        if (empty($output)) {
            $output = 'All migrations are deleted!';
        } else {
            $output = $output;
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $output;
    }
}