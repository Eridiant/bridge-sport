<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%stat_user_ip}}".
 *
 * @property int $id
 * @property int $ip
 * @property string|null $url
 * @property string|null $ref
 * @property string|null $lang_choose
 * @property string|null $lang_all
 * @property string|null $device
 * @property int $created_at
 */
class StatUserIp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stat_user_ip}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip'], 'required'],
            [['ip', 'created_at'], 'integer'],
            [['url', 'ref', 'lang_all', 'device'], 'string', 'max' => 255],
            [['lang_choose'], 'string', 'max' => 12],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => function() { return date('U'); },
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
            'ip' => 'Ip',
            'url' => 'Url',
            'ref' => 'Ref',
            'lang_choose' => 'Lang Choose',
            'lang_all' => 'Lang All',
            'device' => 'Device',
            'created_at' => 'Created At',
        ];
    }
}
