<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%user_info}}".
 *
 * @property int $user_id
 * @property int|null $viewed_ntf_at
 * @property int|null $previos_at
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $city
 * @property string|null $region
 *
 * @property User $user
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_info}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['viewed_ntf_at', 'previos_at'], 'integer'],
            [['name', 'surname', 'city', 'region'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'viewed_ntf_at' => 'Viewed Ntf At',
            'previos_at' => 'Previos At',
            'name' => 'Name',
            'surname' => 'Surname',
            'city' => 'City',
            'region' => 'Region',
        ];
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
