<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string|null $message
 * @property int|null $show
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property MessageReply[] $messageReplies
 * @property Post $post
 * @property User $user
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'message'], 'required'],
            [['post_id', 'user_id', 'show', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['history'], 'string'],
            ['message', 'checkMessage'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function checkMessage($attribute, $params) {
        if (!Yii::$app->user->can('admin')) {
            $nLines = substr_count($this->message, "<div>") + substr_count($this->message, "<br>") + substr_count($this->message, PHP_EOL);
            $nLines = $nLines >= 15 ? ($nLines - 15 ) * 500 : 0;
            $lengs = strlen($this->message);
            $summ = $lengs + $nLines;
            if ($summ > 5000) {
                $this->addError($attribute, 'Слишком длинное сообщение');
            }
        }
        $lengs = mb_strlen(preg_replace('/[^a-zа-я]/ui', '', strip_tags($this->message)));
        // $this->addError($attribute, $lengs);
        if ($lengs < 2) {
            $this->addError($attribute, 'Напишите сообщение');
        }
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->message = strip_tags(str_replace('</div>', '<br>', $this->message), '<br>');
            return true;
        }
        return false;
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // 'value' => new \yii\db\Expression('NOW()'),
                'value' => time(),
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
            'user_id' => 'User ID',
            'message' => 'сообщение',
            'history' => 'History',
            'show' => 'Show',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[MessageReplies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessageReplies()
    {
        return $this->hasMany(MessageReply::class, ['message_id' => 'id']);
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
