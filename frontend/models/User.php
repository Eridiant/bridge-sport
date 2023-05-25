<?php

namespace frontend\models;

use Yii;
use frontend\models\poll\Poll;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property AnswerUser[] $answerUsers
 * @property SurveyMessageReply[] $surveyMessageReplies
 * @property SurveyMessage[] $surveyMessages
 * @property Survey[] $surveys
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * Gets query for [[AnswerUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerUsers()
    {
        return $this->hasMany(AnswerUser::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Surveys]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurveys()
    {
        return $this->hasMany(Survey::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[PollResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPollResponses()
    {
        return $this->hasMany(PollResponse::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserInfos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[PollUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPollUsers()
    {
        return $this->hasMany(PollUser::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Polls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPolls()
    {
        return $this->hasMany(Poll::class, ['id' => 'poll_id'])->viaTable('{{%poll_user}}', ['user_id' => 'id']);
    }
}
