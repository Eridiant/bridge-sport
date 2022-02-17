<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "bsip_survey".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property string|null $img
 * @property string|null $keywords
 * @property string|null $preview
 * @property string|null $description
 * @property int|null $type
 * @property int|null $access
 * @property int|null $active
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Quiz[] $quizzes
 * @property SurveyMessage[] $surveyMessages
 * @property User $user
 */
class Survey extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bsip_survey';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'slug', 'created_at'], 'required'],
            [['user_id', 'type', 'access', 'active', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['preview', 'description'], 'string'],
            [['name', 'slug', 'img', 'keywords'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'img' => 'Img',
            'keywords' => 'Keywords',
            'preview' => 'Preview',
            'description' => 'Description',
            'type' => 'Type',
            'access' => 'Access',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Quizzes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuizzes()
    {
        return $this->hasMany(Quiz::className(), ['survey_id' => 'id']);
    }

    /**
     * Gets query for [[SurveyMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyMessages()
    {
        return $this->hasMany(SurveyMessage::className(), ['survey_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
