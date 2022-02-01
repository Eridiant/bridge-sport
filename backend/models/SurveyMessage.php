<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%survey_message}}".
 *
 * @property int $id
 * @property int $survey_id
 * @property int $user_id
 * @property string|null $message
 * @property int|null $show
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Survey $survey
 * @property SurveyMessageReply[] $surveyMessageReplies
 * @property User $user
 */
class SurveyMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%survey_message}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['survey_id', 'user_id', 'created_at'], 'required'],
            [['survey_id', 'user_id', 'show', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['message'], 'string'],
            [['survey_id'], 'exist', 'skipOnError' => true, 'targetClass' => Survey::class, 'targetAttribute' => ['survey_id' => 'id']],
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
            'survey_id' => 'Survey ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'show' => 'Show',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Survey]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurvey()
    {
        return $this->hasOne(Survey::class, ['id' => 'survey_id']);
    }

    /**
     * Gets query for [[SurveyMessageReplies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyMessageReplies()
    {
        return $this->hasMany(SurveyMessageReply::class, ['survey_message_id' => 'id']);
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
