<?php

namespace backend\controllers;

use Yii;
use backend\models\system\Bid;
use backend\models\system\BidTbl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BidController implements the CRUD actions for Bid model.
 */
class BidController extends AppController
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
    //                 'class' => VerbFilter::className(),
    //                 'actions' => [
    //                     'delete' => ['POST'],
    //                 ],
    //             ],
    //         ]
    //     );
    // }

    /**
     * Lists all Bid models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Bid::find(),
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
     * Displays a single Bid model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Bid();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionFill()
    {
        $request = Yii::$app->request;

        $system_id = $request->post('system_id');
        $parent_id = $request->post('parent_id');
        $pass = $request->post('pass_count') ?? 0;
        // $system_id = 1;
        // $parent_id = 12;
        // $pass = "pass = 0" ;
        // ${pass} , num, bid  {{%bid}}.
        $sql = "SELECT {{%bid}}.id, parent_id, bid_tbl_id, pass, excerpt, num, `description`, bid
        FROM {{%bid}}
        LEFT JOIN {{%bid_tbl}} ON {{%bid_tbl}}.id = {{%bid}}.bid_tbl_id
        WHERE system_id = {$system_id} AND parent_id = {$parent_id} AND pass = {$pass}
        ORDER BY {{%bid_tbl}}.id
        ";
        $model = \Yii::$app->db->createCommand($sql)->queryAll();
        // $model = Bid::find()
        //     ->select('{{%bid}}.id, bid_tbl_id, parent_id, pass, excerpt, num, bid')
        //     ->where(['system_id' => $system_id, 'parent_id' => $parent_id, 'pass' => $pass ])
        //     // ->join('LEFT JOIN', '{{%bidTbl}}', '{{%bidTbl}}.id = {{%bid}}.bid_tbl_id')
        //     // ->leftJoin('{{%bid_tbl}}', '{{%bid_tbl}}.id = {{%bid}}.bid_tbl_id')
        //     ->joinWith(['bidTbl'])
        //     ->all();
// var_dump('<pre>');
// var_dump($model);
// var_dump('</pre>');
// die;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // return $model;
        return ['data' => $model];
    }

    public function actionAdd()
    {
        $request = Yii::$app->request;

        if ($bid_id = $request->post('bid_id')) {
            $model = $this->findModel($bid_id);
        } else {
            $model = new Bid();
        }

        $model->system_id = $request->post('system_id');
        $model->bid_tbl_id = $this->findBid($request->post('bid_num'));
        $model->parent_id = $request->post('parent_id');
        $model->pass = $request->post('pass_count');
        $model->excerpt = $this->clearTag($request->post('excerpt'));
        $model->description = $this->clearTag($request->post('details'));

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if($model->save()){
            return ['data' => ['id' => $model->id, 'excerpt' => $model->excerpt, 'description' => $model->description]];
        } else {
            return ['data' => ['err' => $model->getErrors()]];
        }
        return ['data' => compact('bid_id', 'system_id', 'bid_tbl_id', 'parent_id', 'pass', 'excerpt')];
        return ['data' => ['short' => $short]];

    }

    protected function clearTag($html)
    {
        $text = strip_tags($html, '<br>');
        $text = str_replace('<br>', PHP_EOL, $text);
        $text = trim($text);
        $text = htmlspecialchars($text);
        return $text;
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');

        $bids = $this->findBidAll();
        $pass = $this->findBidPass();

        return $this->render('edit', compact('id', 'bids', 'pass'));
    }

    /**
     * Updates an existing Bid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Bid model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDel()
    {
        $request = Yii::$app->request;

        if (!$id = $request->post('id')) return;

        $this->findModel($id)->delete();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ['success' => true];
    }

    /**
     * Finds the Bid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Bid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bid::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findBid($id)
    {
        if (($model = BidTbl::findOne(['num' => $id])) !== null) {
            return $model->id;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findBidAll()
    {
        if (($model = BidTbl::find()->where(['>', 'lvl', 0])) !== null) {
            return $model->all();
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findBidPass()
    {
        if (($model = BidTbl::find()->where(['lvl' => 0])) !== null) {
            return $model->all();
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    // protected function findValues()
    // {
    //     if (($model = BidTbl::find()->where(['lvl' => 0])) !== null) {
    //         return $model->all();
    //     }

    //     throw new NotFoundHttpException('The requested page does not exist.');
    // }
}
