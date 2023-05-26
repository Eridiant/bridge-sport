<?php

namespace backend\models\poll;

use Yii;
use backend\models\Post;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%poll}}".
 *
 * @property int $id
 * @property int $post_id
 * @property string|null $description
 * @property int $show_result
 * @property int $save_result
 * @property int $save_response
 * @property int $show_only_user_result
 * @property int $show_grade
 * @property int $poll_close
 * @property int $allow_guest
 * @property int $save_guest_result
 * @property int $active
 * @property int $created_at
 *
 * @property PollQuestion[] $pollQuestions
 * @property PollUser[] $pollUsers
 * @property Post $post
 * @property User[] $users
 */
class Poll extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%poll}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id'], 'required'],
            [['post_id', 'show_result', 'save_response', 'save_result', 'show_only_user_result', 'show_grade', 'poll_close', 'allow_guest', 'save_guest_result', 'active', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
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
            'id' => 'ID',
            'post_id' => 'Post ID',
            'description' => 'Description',
            'show_result' => 'Вывести результат в виде графика',
            'save_result' => 'Сохранять результат голосования',
            'save_response' => 'Сохранять ответы пользователей',
            'show_only_user_result' => 'Вывести результаты только зарегистрированных пользователей',
            'show_grade' => 'Вывести оценку',
            'poll_close' => 'Завершить опрос',
            'allow_guest' => 'Разрешить для гостей',
            'save_guest_result' => 'Сохранить результат для гостей',
            'active' => 'Active',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[PollQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(PollQuestion::class, ['poll_id' => 'id']);
    }

    /**
     * Gets query for [[PollUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPollUsers()
    {
        return $this->hasMany(PollUser::class, ['poll_id' => 'id']);
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('{{%poll_user}}', ['poll_id' => 'id']);
    }
}
