<?php

namespace backend\controllers;

use Yii;
use backend\models\SysItm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SysItmController implements the CRUD actions for SysItm model.
 */
class SysItmController extends Controller
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
     * Lists all SysItm models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SysItm::find(),
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
     * Displays a single SysItm model.
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
     * Creates a new SysItm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SysItm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $model->syst_id = Yii::$app->request->get('id');

        return $this->render('create', compact('model'));
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');

        return $this->render('edit', compact('id'));
    }

    public function actionCheck($id = null)
    {
        $request = Yii::$app->request;

        if ($this->request->isPost) {
            if ($id == null) {
                $model = new SysItm();
            } else {
                $model = $this->findModel($id);
            }
            if ($model->load($this->request->post())) {
                $model->lvl = 1 + (int)$model->lvl;
                $model->converted = $this->convert($model->description);
                if ($model->save()) {
                    $id = $this->request->get('syst_id');
                    return $this->render('edit', compact('id'));
                }
            }
        }

        

        // $model = SysItm::find()
                // ->where(['parent_id' => $request->get('parent_id'), 'syst_id' => $request->get('syst_id')]);
        
        // if (!empty($request->get('answer_id'))) {
        //     $model = $model->andWhere(['answer_id' => $request->get('answer_id')]);
        // }
        
        // $model = $model->one();
        // $searchModel = new QuizSearch();
        // $dataProvider = $searchModel->search($this->request->queryParams);
        // if (!empty($model)) {
        //     return $this->render('update', compact('model'));
        // }

        $model = new SysItm();

        $model->parent_id = $request->get('parent_id');
        $model->syst_id = $request->get('syst_id');
        $model->lvl = $request->get('lvl');
        // $model->answer_id = $request->get('answer_id');
        
        return $this->render('create', compact('model'));
    }

    /**
     * Updates an existing SysItm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->converted = $this->convert($model->description);
            if ($model->save()) {
                $id = $model->syst_id;
            }

            return $this->render('edit', compact('id'));
            // return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SysItm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $id = $model->syst_id;
        $model->delete();

        return $this->render('edit', compact('id'));
        // return $this->redirect(['index']);
    }

    /**
     * Finds the SysItm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SysItm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysItm::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function convert($description)
    {
        $converted = '';

        $converted = preg_replace("/(?<=\d)тр((?=\s)|$)/", '<img src="/img/c.svg"> ', $description);
        $converted = preg_replace("/(?<=\s)тт((?=\s)|$)/", '<img src="/img/c.svg"> ', $converted);
        $converted = preg_replace("/(?<=\d)б((?=\s)|$)/", '<img src="/img/d.svg"> ', $converted);
        $converted = preg_replace("/(?<=\s)бб((?=\s)|$)/", '<img src="/img/d.svg"> ', $converted);
        $converted = preg_replace("/(?<=\d)ч((?=\s)|$)/", '<img src="/img/h.svg"> ', $converted);
        $converted = preg_replace("/(?<=\s)чч((?=\s)|$)/", '<img src="/img/h.svg"> ', $converted);
        $converted = preg_replace("/(?<=\d)п((?=\s)|$)/", '<img src="/img/s.svg"> ', $converted);
        $converted = preg_replace("/(?<=\s)пп((?=\s)|$)/", '<img src="/img/s.svg"> ', $converted);
        return $converted;
    }
}
