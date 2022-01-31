<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%answer}}".
 *
 * @property int $id
 * @property int $quiz_id
 * @property string|null $description
 *
 * @property AnswerUser[] $answerUsers
 * @property Quiz $quiz
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%answer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id'], 'required'],
            [['quiz_id'], 'integer'],
            [['description'], 'string'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::class, 'targetAttribute' => ['quiz_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_id' => 'Quiz ID',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[AnswerUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerUsers()
    {
        return $this->hasMany(AnswerUser::class, ['answer_id' => 'id']);
    }

    /**
     * Gets query for [[Quiz]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::class, ['id' => 'quiz_id']);
    }
}
