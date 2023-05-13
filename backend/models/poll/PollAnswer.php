<?php

namespace backend\models\poll;

use Yii;

/**
 * This is the model class for table "{{%poll_answer}}".
 *
 * @property int $id
 * @property int $question_id
 * @property string|null $text
 * @property int|null $is_correct
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
            [['question_id', 'is_correct'], 'integer'],
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
            'is_correct' => 'Is Correct',
        ];
    }

    /**
     * Gets query for [[PollResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(PollResponse::class, ['answer_id' => 'id']);
    }

    /**
     * Gets query for [[PollResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResults()
    {
        return $this->hasMany(PollResult::class, ['answer_id' => 'id']);
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
