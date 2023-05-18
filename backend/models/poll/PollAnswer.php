<?php

namespace backend\models\poll;

use Yii;

/**
 * This is the model class for table "{{%poll_answer}}".
 *
 * @property int $id
 * @property int $question_id
 * @property string|null $text
 *
 * @property PollResponse[] $pollResponses
 * @property PollResult[] $pollResults
 * @property PollQuestion $question
 */
class PollAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%poll_answer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id'], 'required'],
            [['question_id'], 'integer'],
            [['text'], 'string'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollQuestion::class, 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'text' => 'Text',
        ];
    }

    /**
     * Gets query for [[PollResponse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponse()
    {
        return $this->hasOne(PollResponse::class, ['answer_id' => 'id']);
    }

    /**
     * Gets query for [[PollResult]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResult()
    {
        return $this->hasOne(PollResult::class, ['answer_id' => 'id']);
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(PollQuestion::class, ['id' => 'question_id']);
    }
}
