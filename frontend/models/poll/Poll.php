<?php

namespace frontend\models\poll;

use Yii;
use frontend\models\Post;

/**
 * This is the model class for table "{{%poll}}".
 *
 * @property int $id
 * @property int $post_id
 * @property string|null $description
 * @property int $show_result
 * @property int $save_result
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
            [['post_id', 'show_result', 'save_result', 'show_only_user_result', 'show_grade', 'poll_close', 'allow_guest', 'save_guest_result', 'active', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
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
            'show_result' => 'Show Result',
            'show_only_user_result' => 'Show Only User Result',
            'save_result' => 'Save Result',
            'show_grade' => 'Show Grade',
            'poll_close' => 'Show Grade',
            'allow_guest' => 'Allow Guest',
            'save_guest_result' => 'Save Guest Result',
            'active' => 'Active',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[PollQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPollQuestions()
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
        return $this->hasOne(PollUser::class, ['poll_id' => 'id'])->andWhere(['user_id' => Yii::$app->user->id]);
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
