<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%stat_user_ip}}".
 *
 * @property int $id
 * @property int $ip
 * @property string $ip6
 * @property int|null $status
 * @property string|null $url
 * @property string|null $ref
 * @property string|null $lang_choose
 * @property string|null $lang_all
 * @property string|null $device
 * @property int|null $bot
 * @property string|null $country_code
 * @property string|null $country_name
 * @property string|null $region
 * @property string|null $city
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
            [['ip', 'ip6'], 'required'],
            [['ip', 'status', 'bot', 'created_at'], 'integer'],
            [['ip6'], 'string', 'max' => 39],
            [['url', 'ref', 'device', 'country_name', 'region', 'city'], 'string', 'max' => 255],
            [['lang_choose', 'country_code'], 'string', 'max' => 12],
            [['lang_all'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
            'ip6' => 'Ip6',
            'status' => 'Status',
            'url' => 'Url',
            'ref' => 'Ref',
            'lang_choose' => 'Lang Choose',
            'lang_all' => 'Lang All',
            'device' => 'Device',
            'bot' => 'Bot',
            'country_code' => 'Country Code',
            'country_name' => 'Country',
            'region' => 'Region',
            'city' => 'City',
            'created_at' => 'Created At',
        ];
    }
}
