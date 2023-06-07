<?php

namespace frontend\controllers;

use Yii;
use frontend\models\poll\Poll;
use frontend\models\poll\PollQuestion;
use frontend\models\poll\PollAnswer;
use frontend\models\poll\PollResponse;
use frontend\models\poll\PollResult;
use frontend\models\poll\PollUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PollController implements the CRUD actions for Poll model.
 */
class PollController extends Controller
{

    public $test = '{
        "response": "<div class=\"poll-question-view\">\n\n    <h1></h1>\n\n    <p>\n        asdfasdfasdf\n    </p>\n\n</div>\n",
        "user": 1,
        "rslt": [
          {
            "id": 1,
            "poll_id": 1,
            "type": 1,
            "text": "текст",
            "comment": "",
            "answers": [
              {
                "id": 1,
                "question_id": 1,
                "text": "111122222222222222222222222",
                "result": {
                  "id": 1,
                  "answer_id": 1,
                  "result_count": 1,
                  "text": "aadfasdfasdfasd",
                  "is_correct": 1
                }
              },
              {
                "id": 2,
                "question_id": 1,
                "text": "332342344412341234",
                "result": {
                  "id": 2,
                  "answer_id": 2,
                  "result_count": 2,
                  "text": "asdfasdff33333",
                  "is_correct": 3
                }
              },
              {
                "id": 3,
                "question_id": 1,
                "text": "12344432412341234",
                "result": {
                  "id": 3,
                  "answer_id": 3,
                  "result_count": 1,
                  "text": "dsfasdf555544455",
                  "is_correct": 5
                }
              },
              {
                "id": 6,
                "question_id": 1,
                "text": "тема",
                "result": {
                  "id": 4,
                  "answer_id": 6,
                  "result_count": 1,
                  "text": "rgty76rg6r675555555555",
                  "is_correct": 6
                }
              },
              {
                "id": 7,
                "question_id": 1,
                "text": "текст",
                "result": {
                  "id": 5,
                  "answer_id": 7,
                  "result_count": 0,
                  "text": "sdfasdfasdfsd",
                  "is_correct": 10
                }
              }
            ]
          },
          {
            "id": 2,
            "poll_id": 1,
            "type": 0,
            "text": "фывафывафыва",
            "comment": "\n        \n        фывафывафывфываыа        ",
            "answers": [
              {
                "id": 4,
                "question_id": 2,
                "text": "12343426534563467y478tryurty",
                "result": {
                  "id": 6,
                  "answer_id": 4,
                  "result_count": 0,
                  "text": "sdfgsdfdfsg",
                  "is_correct": 1
                }
              },
              {
                "id": 5,
                "question_id": 2,
                "text": "2346rtyh646uy7hry645",
                "result": {
                  "id": 7,
                  "answer_id": 5,
                  "result_count": 2,
                  "text": "sdfggggggdfsgdfsgsdfg",
                  "is_correct": 10
                }
              }
            ]
          },
          {
            "id": 3,
            "poll_id": 1,
            "type": 3,
            "text": "текстцукецуке",
            "comment": null,
            "answers": [
              {
                "id": 8,
                "question_id": 3,
                "text": "test",
                "result": {
                  "id": 9,
                  "answer_id": 8,
                  "result_count": 2,
                  "text": "sdgsfgdsfgsdfgsdfgdf",
                  "is_correct": 2
                }
              },
              {
                "id": 9,
                "question_id": 3,
                "text": "тост",
                "result": {
                  "id": 8,
                  "answer_id": 9,
                  "result_count": 0,
                  "text": "sdfgdfgdfsgsdfgsdf",
                  "is_correct": 9
                }
              }
            ]
          }
        ],
        "question": {
          "id": 3,
          "poll_id": 1,
          "type": 3,
          "text": "текстцукецуке",
          "comment": null
        }
      }';

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
                    ],
                ],
            ]
        );
    }

    public function actionResults()
    {
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // return json_decode($this->test);

        $request = Yii::$app->request;

        $user = Yii::$app->user;

        $rslt = [];
        // $rslt = new class{};
        // $result = new StdClass();
        // $post = '{"1":["2","3","6"],"2":["5"],"3":["test"]}';
        // $post = json_decode($post);
        // var_dump('<pre>');
        // var_dump($request->post());
        // var_dump('</pre>');
        // die;
        $id = (int) $request->post('poll');

        if (($poll = Poll::findOne($id)) === null || $poll->active == 0) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['error' => 'в бобруйск'];
        }

        $poll_question = $request->post();

        if(isset($poll_question['poll']))
        {
            unset($poll_question['poll']);
        }

        $poll_user = PollUser::findOne(['poll_id' => $id, 'user_id' => $user->id]);
        if (isset($poll_user)) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['error' => 'в бабровск'];
        }
        $poll_user = new PollUser();

        $is_guest = Yii::$app->user->isGuest;
        
        foreach ($poll_question as $key => $value) {
        // foreach ($post as $key => $value) {
            // $result[] = $this->resultModel($id);
            // continue;
            $key = preg_replace("/[^0-9]/", "", $key);
            $question = $this->questionModel($key);

            if ( $poll->save_result == 0 || ($is_guest && $poll->save_guest_result == 0)) {
                $rslt[] = $this->questionArray($key);
                $result = '';
                continue;
            }

            switch ($question->type) {
                case '2':
                    $num = preg_replace("/[^0-9]/", "", $value[0]);
                    $answer = $this->findAnswer($key, $num);
                    if (isset($answer->result->result_count)) {
                        // $answer->result->result_count = $answer->result->result_count + 1;
                        if ($is_guest) {
                            $answer->result->result_guest_count = $answer->result->result_guest_count + 1;
                        } else {
                            $answer->result->result_count = $answer->result->result_count + 1;
                        }
                        $answer->result->save();
                    }
                    break;

                case '3':
                    $text = preg_replace("/[^a-zA-Zа-яА-Я\s]/", "", $value[0]);
                    $text = preg_replace("/\s+/", " ", trim($text));
                    $answer = $this->findAnswer($key, $text);
                    if (isset($answer->result->result_count)) {
                        // $answer->result->result_count = $answer->result->result_count + 1;
                        if ($is_guest) {
                            $answer->result->result_guest_count = $answer->result->result_guest_count + 1;
                        } else {
                            $answer->result->result_count = $answer->result->result_count + 1;
                        }
                        $answer->result->save();
                    }
                    break;

                case '0':
                case '1':
                    foreach ($value as $id) {
                        $answer_id = preg_replace("/[^0-9]/", "", $id);
                        $result = $this->findResult($answer_id);
                        if (isset($result->result_count)) {
                            if ($is_guest) {
                                $result->result_guest_count = $result->result_guest_count + 1;
                            } else {
                                $result->result_count = $result->result_count + 1;
                            }
                            $result->save();
                        }
                    }
                    break;
                default:
                    break;
            }
            $rslt[] = $this->questionArray($key);
        }

        $show_result = $question->poll->show_result;
        $show_only_user_result = $question->poll->show_only_user_result;

        if ($poll->save_result === 1 && !$is_guest) {
            $poll_user->poll_id = $question->poll->id;
            $poll_user->user_id = $user->id;
            if (!$poll_user->save()) {
                var_dump('<pre>');
                var_dump($poll_user->getErrors());
                var_dump('</pre>');
                die;
            }
        }

        // $question->poll->pollUsers->poll_id = $question->poll->id;
        // $question->poll->pollUsers->user_id = $user->id;
        // if (!$question->poll->pollUsers->save()) {
        //     var_dump('<pre>');
        //     var_dump($question->poll->pollUsers->getErrors());
        //     var_dump('</pre>');
        //     die;
        // }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // $render = $this->renderPartial('results', compact('result'));
        return ['show_result' => $show_result, 'rslt' => $rslt, 'show_only_user_result' => $show_only_user_result];
    }

    protected function findAnswer($id, $text)
    {
        return $answer = PollAnswer::findOne(['question_id' => $id, 'text' => $text]);
    }

    protected function findResult($answer_id)
    {
        if (($result = PollResult::findOne(['answer_id' => $answer_id])) !== null) {
            return $result;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
        // PollResult::updateAllCounters(['votes' => 1], ['id' => $answer_id]);
    }

    protected function resultModel($id)
    {
        if (($model = PollResult::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function questionArray($id)
    {
        $model = PollQuestion::find()
            ->with(['answers', 'answers.result'])
            // ->joinWith(['answers', 'answers.result'])
            ->where(['id' => $id])
            ->asArray()
            ->one();
        if ($model !== null) {
            return $model;
        }

        return null;
        // throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function questionModel($id)
    {
        $model = PollQuestion::find()
            ->with(['answers', 'answers.result'])
            // ->joinWith(['answers', 'answers.result'])
            ->where(['id' => $id])
            ->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Lists all Poll models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Poll::find(),
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
     * Displays a single Poll model.
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
     * Creates a new Poll model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new Poll();

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
     * Updates an existing Poll model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Deletes an existing Poll model.
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
     * Finds the Poll model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Poll the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Poll::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
