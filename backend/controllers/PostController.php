<?php

namespace backend\controllers;

use Yii;
use backend\models\Post;
use backend\models\Image;
use backend\models\Iframe;
use backend\models\Youtube;
use backend\models\PostSearch;
use backend\models\Category;
use backend\models\CategorySearch;
use backend\models\Attribute;
use backend\models\AttributeSearch;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['login', 'error'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['logout', 'index', 'delete', 'update', 'create'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST', 'GET'],
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
    public function actionCreate($id = 0, $parent = 0)
    {

        $model = new Post();
        
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->author_id = Yii::$app->user->getId();

                $model->url = $this->createUrl($model->category_id, $model->slug);

                // $image = new Image();
                // $image->url = UploadedFile::getInstance($model, 'img');

                // if ($filename = $image->upload()) {

                //     // $image = new Image();
                //     $image->url = $filename;
                //     $image->alt = $model->alt;
                    
                //     if ($image->save()) {
                //         $model->image_id = $image->getPrimaryKey();
                //     } else {
                //         var_dump('<pre>');
                //         var_dump($image->getErrors());
                //         var_dump('</pre>');
                //         die;
                //     }
                // }

                // if ($model->iframe) {
                //     $iframe = new Iframe();
                //     $iframe->frame = $model->iframe;
                //     $iframe->only_img = $model->only_img;
                //     $iframe->preview = $model->preview;
                //     if ($iframe->save()) {
                //         $model->iframe_id = $iframe->getPrimaryKey();
                //     } else {
                //         var_dump('<pre>');
                //         var_dump($iframe->getErrors());
                //         var_dump('</pre>');
                //         die;
                //     }
                // }

                // if ($model->youtube) {
                //     $youtube = new Youtube();
                //     $youtube->youtube = $model->youtube;
                //     $youtube->hide = $model->hide;
                //     $youtube->key = 'key';
                //     // $youtube->image_id = 'image';
                //     if ($youtube->save()) {
                //         $model->youtube_id = $youtube->getPrimaryKey();
                //     } else {
                //         var_dump('<pre>');
                //         var_dump($youtube->getErrors());
                //         var_dump('</pre>');
                //         die;
                //     }
                // }

                $check = Post::find()->with('category')
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
                } else {
                    var_dump('<pre>');
                    var_dump($model->getErrors());
                    var_dump('</pre>');
                    die;
                    
                }


            } else {
                $model->loadDefaultValues();
            }
        }

        if ($id) {
            $model->category_id = $id;
        }

        if ($parent) {
            $model->parent_id = $parent;
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

        if ($this->request->isPost && $model->load($this->request->post())) {

            // if (!is_null(UploadedFile::getInstance($model, 'img'))) {
            //     $model->img = UploadedFile::getInstance($model, 'img');
            //     $model->img = $model->upload();
            // }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                var_dump('<pre>');
                var_dump($model->getErrors());
                var_dump('</pre>');
                die;
            }

        }

        return $this->render('create', [
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
        $model = Post::find()
            ->where(['id' => $id])
            // ->joinWith('image')
            // ->with('image')
            // ->all()
            ->one()
            ;
        // var_dump('<pre>');
        // var_dump($model->image);
        // var_dump('</pre>');
        // die;
        
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
