<?php

namespace frontend\controllers;

use frontend\models\Post;
use frontend\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends AppController
{

    /**
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {

        // var_dump($this->request->queryParams);
        
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        // $dataProvider = $dataProvider->;
        $model = $dataProvider->getModels();
        
        // $this->setMeta('', '');
        return $this->render('index', compact('model'));
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
    public function actionShow($id)
    {
        $model = $this->findModel($id);

        $this->setMeta( empty($model->title) ? $model->name : $model->title, empty($model->description) ? $model->preview : $model->description, $model->keywords, $model->image->path);

        return $this->render('show', compact('model'));
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
            ->with('image')
            ->where(['id' => $id])
            ->andWhere(['status' => 1])
            ->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
