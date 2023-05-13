<?php

namespace backend\models\poll;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%poll_response}}".
 *
 * @property int $id
 * @property int $answer_id
 * @property int $user_id
 * @property int|null $date
 *
 * @property PollAnswer $answer
 * @property User $user
 */
class PollResponse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%poll_response}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer_id', 'user_id'], 'required'],
            [['answer_id', 'user_id', 'date'], 'integer'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollAnswer::class, 'targetAttribute' => ['answer_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
