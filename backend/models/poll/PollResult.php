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
 * @property int|null $date
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
            [['answer_id', 'result_count', 'date'], 'integer'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollAnswer::class, 'targetAttribute' => ['answer_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                ],
            ],
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
            'date' => 'Date',
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
