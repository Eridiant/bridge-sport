<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%survey_message_reply}}".
 *
 * @property int $id
 * @property int $survey_message_id
 * @property int $answer_id
 * @property int $user_id
 * @property string|null $message
 * @property int|null $show
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property SurveyMessage $surveyMessage
 * @property User $user
 */
class SurveyMessageReply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%survey_message_reply}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['survey_message_id', 'answer_id', 'user_id', 'created_at'], 'required'],
            [['survey_message_id', 'answer_id', 'user_id', 'show', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['message'], 'string'],
            [['survey_message_id'], 'exist', 'skipOnError' => true, 'targetClass' => SurveyMessage::class, 'targetAttribute' => ['survey_message_id' => 'id']],
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
            'survey_message_id' => 'Survey Message ID',
            'answer_id' => 'Answer ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'show' => 'Show',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[SurveyMessage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyMessage()
    {
        return $this->hasOne(SurveyMessage::class, ['id' => 'survey_message_id']);
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
