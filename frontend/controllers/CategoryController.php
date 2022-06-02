<?php

namespace frontend\controllers;

use frontend\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends AppController
{
    /**
     * @inheritDoc
     */
    // public function behaviors()
    // {
    //     return array_merge(
    //         parent::behaviors(),
    //         [
    //             'verbs' => [
    //                 'class' => VerbFilter::class,
    //                 'actions' => [
    //                     'delete' => ['POST'],
    //                 ],
    //             ],
    //         ]
    //     );
    // }

    /**
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // $model = $this->findModel($id);
        // var_dump('<pre>');
        // var_dump($model->posts);
        // var_dump('</pre>');
        // die;
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        $model = Category::find()
        ->With('posts')
        ->where(['id' => $id])
        ->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
