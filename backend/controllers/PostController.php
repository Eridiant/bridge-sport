<?php

namespace backend\controllers;

use Yii;
use backend\models\Post;
use backend\models\PostSearch;
use backend\models\Category;
use backend\models\CategorySearch;
use backend\models\Attribute;
use backend\models\AttributeSearch;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id = 0)
    {

        $model = new Post();

        $model->category_id = $id;
        $model->author_id = Yii::$app->user->getId();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->url = $this->createUrl($model->category_id, $model->slug);

                $model->img = UploadedFile::getInstance($model, 'img');

                if ($filename = $model->upload()) {
                    $model->img = $filename;
                }

                $check = Post::find()->with('category')
                            // ->select(['slug', 'category_id'])
                            ->where([
                                'slug' => $model->slug,
                                'category_id' => $model->category_id
                                ])
                            ->exists();

                if ($check) {
                    // $model->loadDefaultValues();
                    Yii::$app->session->setFlash("категория и слаг совпадают");
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            } else {
                var_dump('<pre>');
                var_dump($model->getErrors());
                var_dump('</pre>');
                die;
                
            }
        } else {
            $model->loadDefaultValues();
        }

        // $attributes = Attribute::find()->all();

        return $this->render('create', compact('model'));
    }

    protected function createUrl($category_id, $slug)
    {
        do {
            $category = Category::find()
                        ->select(['parent_id', 'slug'])
                        ->where(['id' => $category_id])
                        ->one();

            $slug = $category->slug . '/'. $slug;
            $category_id = $category->parent_id;

        } while ($category_id != 0);

        return $slug;
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            if (!is_null(UploadedFile::getInstance($model, 'img'))) {
                $model->img = UploadedFile::getInstance($model, 'img');
                $model->img = $model->upload();
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
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

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
