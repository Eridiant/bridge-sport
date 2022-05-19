<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Post;
use frontend\models\Answer;
use frontend\models\Quiz;
use frontend\models\Survey;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SurveyController implements the CRUD actions for Post model.
 */
class SurveyController extends Controller
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
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'quiz' => ['POST'],
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
        $model = Survey::find()->all();

        return $this->render('index', compact('model'));
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['data' => ['success' => true]];
        }
        $model = Survey::find()->where(['slug' => $slug])->one();
        
        return $this->render('view', compact('model'));
    }

    public function actionQuiz()
    {

        $request = Yii::$app->request;
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // var_dump('<pre>');
        // print_r($request->post(), true);
        // var_dump(Yii::$app->request->getRawBody());
        // var_dump($request->post('parent_id'));
        // var_dump($request->isAjax);
        // var_dump($request);
        // var_dump($quiz);
        // var_dump($survey_id);
        // var_dump(json_decode($request->post()));
        // var_dump(json_decode($request->getRawBody())->survey_id);
        // var_dump('</pre>');
        // die;
        
        if ($request->isPost) {

            $survey_id = $request->post('survey_id');
            $parent_id = is_null($request->post('parent_id')) ? 0 : $request->post('parent_id');
            $answer_id = is_null($request->post('answer_id')) ? null : $request->post('answer_id');
            $model = Quiz::find()
                    ->with('answers')
                    // ->where(['survey_id' => $survey_id, 'parent_id' => $parent_id])
                    // ->where(['survey_id=:survey_id', 'parent_id=:parent_id'])
                    ->where('survey_id=:survey_id')
                    // ->addParams([':survey_id' => $survey_id, ':parent_id' => $parent_id])
                    ->addParams([':survey_id' => $survey_id])
                    ->andWhere('parent_id=:parent_id')
                    ->addParams([':parent_id' => $parent_id]);

            if (!is_null($answer_id)) {
                $model = $model->andWhere('answer_id=:answer_id')
                    ->addParams([':answer_id' => $answer_id]);
            }

            $model = $model->one();
            
            if (is_null($model)) {
                $model = Survey::find()->where(['id' => $survey_id])->one();
                
                return $this->renderPartial('_result', compact('model'));
                // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                // return Yii::$app->response->redirect(['site/index']);
                // return Yii::$app->response->redirect('site/index');
                // return $this->redirect('site/index', 302);
                // return ['data' => ['success' => false]];
                // Yii::$app->getResponse()->redirect(Yii::$app->request->referrer, 302, FALSE);
                // return Yii::$app->getResponse()->redirect('/site/index', 302, FALSE);
            }
            // Yii::$app->response->format = \yii\sweb\Response::FORMAT_JSON;
            return $this->renderPartial('_radio', compact('model'));
            // return json_encode($this->renderPartial('_checkbox', compact('model')));
        }
        return ['data' => ['success' => false]];
        $model = Survey::find()->where(['slug' => $slug])->one();
        
        return $this->render('view', compact('model'));
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Post();

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
            return $this->redirect(['view', 'id' => $model->id]);
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
