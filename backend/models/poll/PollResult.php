<?php

namespace backend\models\poll;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%poll_result}}".
 *
 * @property int $id
 * @property int $answer_id
 * @property int|null $result_count
 * @property string|null $text
 * @property int|null $is_correct
 *
 * @property PollAnswer $answer
 */
class PollResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%poll_result}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer_id'], 'required'],
            [['answer_id', 'result_count', 'is_correct'], 'integer'],
            [['text'], 'string'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollAnswer::class, 'targetAttribute' => ['answer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'answer_id' => 'Answer ID',
            'result_count' => 'Result Count',
            'text' => 'Text',
            'is_correct' => 'Is Correct',
        ];
    }

    /**
     * Gets query for [[Answer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(PollAnswer::class, ['id' => 'answer_id']);
    }
}
