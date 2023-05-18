<?php

namespace backend\models\poll;

use Yii;

/**
 * This is the model class for table "{{%poll_question}}".
 *
 * @property int $id
 * @property int $poll_id
 * @property int|null $type
 * @property string|null $text
 * @property string|null $comment
 *
 * @property Poll $poll
 * @property PollAnswer[] $pollAnswers
 */
class PollQuestion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%poll_question}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id'], 'required'],
            [['poll_id', 'type'], 'integer'],
            [['text', 'comment'], 'string'],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Poll::class, 'targetAttribute' => ['poll_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'poll_id' => 'Poll ID',
            'type' => 'Type',
            'text' => 'Text',
            'comment' => 'Comment',
        ];
    }

    /**
     * Gets query for [[Poll]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Poll::class, ['id' => 'poll_id']);
    }

    /**
     * Gets query for [[PollAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(PollAnswer::class, ['question_id' => 'id']);
    }

    /**
     * Gets query for [[PollResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(PollResponse::class, ['question_id' => 'id']);
    }
}
