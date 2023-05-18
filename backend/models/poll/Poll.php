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
 * @property int|null $type
 * @property int|null $show_result
 * @property int|null $grade
 * @property string|null $description
 * @property int|null $active
 * @property int $created_at
 *
 * @property PollQuestion[] $pollQuestions
 * @property Post $post
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
            [['post_id', 'type', 'show_result', 'grade', 'active', 'created_at'], 'integer'],
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
            'type' => 'Type',
            'show_result' => 'Show Result',
            'grade' => 'Grade',
            'description' => 'Description',
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
     * Gets query for [[PollResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(PollResponse::class, ['poll_id' => 'id']);
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
}
