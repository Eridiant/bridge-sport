<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;


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
            [['message_id', 'user_id', 'message'], 'required'],
            [['message_id', 'answer_id', 'answer_user', 'user_id', 'show', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['history'], 'string'],
            ['message', 'checkReply'],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::class, 'targetAttribute' => ['message_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function checkReply($attribute, $params) {
        if (!Yii::$app->user->can('admin')) {
            // strlen(string $this->message);
            // substr_count($this->message, "<div>");
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
        if ($lengs < 1) {
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
            'message_id' => 'Message ID',
            'answer_id' => 'Answer ID',
            'answer_user' => 'Answer User',
            'user_id' => 'User ID',
            'message' => 'ответ',
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
    public function getParent()
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

    public function getAnswer()
    {
        return $this->hasOne(User::class, ['id' => 'answer_user']);
    }

    /**
     * Gets query for [[Message0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(MessageReply::class, ['answer_id' => 'id']);
    }

}
