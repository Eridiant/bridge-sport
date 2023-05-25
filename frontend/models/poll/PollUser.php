<?php

namespace frontend\models\poll;

use Yii;
use frontend\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%poll_user}}".
 *
 * @property int $poll_id
 * @property int $user_id
 * @property int|null $score
 * @property int $created_at
 *
 * @property Poll $poll
 * @property User $user
 */
class PollUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%poll_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id', 'user_id'], 'required'],
            [['poll_id', 'user_id', 'score', 'created_at'], 'integer'],
            [['poll_id', 'user_id'], 'unique', 'targetAttribute' => ['poll_id', 'user_id']],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Poll::class, 'targetAttribute' => ['poll_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
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
            'poll_id' => 'Poll ID',
            'user_id' => 'User ID',
            'score' => 'Score',
            'created_at' => 'Created At',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
