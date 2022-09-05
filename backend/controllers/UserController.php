<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AppController
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
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

    public function actionRole()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $id = $request->post('user');
            $role = $request->post('role');
            $userRole = Yii::$app->authManager->getRole($role);
            Yii::$app->authManager->assign($userRole, $id);
            return true;
        }
        // return $this->render('view', [
        //     'model' => $this->findModel($id),
        // ]);
    }

    public function actionExect()
    {
        // $role = Yii::$app->authManager->createRole('admin');
        // $role->description = 'Администратор';
        // Yii::$app->authManager->add($role);

        // $role = Yii::$app->authManager->createRole('student');
        // $role->description = 'Студент';
        // Yii::$app->authManager->add($role);

        // $role = Yii::$app->authManager->createRole('user');
        // $role->description = 'Пользователь';
        // Yii::$app->authManager->add($role);

        // $role = Yii::$app->authManager->createRole('guest');
        // $role->description = 'Гость';
        // Yii::$app->authManager->add($role);

        // $role = Yii::$app->authManager->getRole('admin');
        // $permit = Yii::$app->authManager->getRole('student');
        // Yii::$app->authManager->addChild($role, $permit);

        // var_dump('<pre>');
        // var_dump(Yii::$app->authManager->getItems('1'));
        // var_dump('</pre>');
        // die;
        

        // $permit = Yii::$app->authManager->createPermission('canAdmin');
        // $permit->description = 'могучий админ';
        // Yii::$app->authManager->add($permit);

        // $userRole = Yii::$app->authManager->getRole('admin');
        // Yii::$app->authManager->assign($userRole, Yii::$app->user->getId());
        var_dump(\Yii::$app->user->can('admin'));
        
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new User();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
