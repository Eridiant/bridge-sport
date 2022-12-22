<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%message_reply}}".
 *
 * @property int $id
 * @property int $message_id
 * @property int|null $answer_id
 * @property int|null $answer_user
 * @property int $user_id
 * @property string|null $message
 * @property string|null $history
 * @property int|null $show
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Message $message0
 * @property User $user
 */
class MessageReply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%message_reply}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message_id', 'user_id', 'created_at'], 'required'],
            [['message_id', 'answer_id', 'answer_user', 'user_id', 'show', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['message', 'history'], 'string'],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::class, 'targetAttribute' => ['message_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_id' => 'Message ID',
            'answer_id' => 'Answer ID',
            'answer_user' => 'Answer User',
            'user_id' => 'User ID',
            'message' => 'Message',
            'history' => 'History',
            'show' => 'Show',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Message0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessage0()
    {
        return $this->hasOne(Message::class, ['id' => 'message_id']);
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
