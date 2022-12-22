<?php

namespace backend\models\system;

use Yii;
use yii\behaviors\TimestampBehavior;
use backend\models\User;

/**
 * This is the model class for table "{{%system}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $hidden
 * @property int $edit
 * @property int|null $updated_at
 * @property int $created_at
 *
 * @property System[] $conventions
 * @property SystemBid[] $systemBs
 * @property SystemSystem[] $systemSystems
 * @property SystemSystem[] $systemSystems0
 * @property System[] $systems
 * @property User $user
 */
class System extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%system}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'slug'], 'required'],
            [['user_id', 'type', 'hidden', 'edit', 'updated_at', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'type' => 'Type',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'hidden' => 'Hidden',
            'edit' => 'Edit',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
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
     * Gets query for [[Conventions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConventions()
    {
        return $this->hasMany(System::class, ['id' => 'convention_id'])->viaTable('{{%system_system}}', ['system_id' => 'id']);
    }

    /**
     * Gets query for [[SystemBids]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystemBids()
    {
        return $this->hasMany(SystemBid::class, ['system_id' => 'id']);
    }

    /**
     * Gets query for [[SystemSystems]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getSystemSystems()
    // {
    //     return $this->hasMany(SystemSystem::class, ['convention_id' => 'id']);
    // }

    /**
     * Gets query for [[SystemSystems0]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getSystemSystems0()
    // {
    //     return $this->hasMany(SystemSystem::class, ['system_id' => 'id']);
    // }

    /**
     * Gets query for [[Systems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystems()
    {
        return $this->hasMany(System::class, ['id' => 'system_id'])->viaTable('{{%system_system}}', ['convention_id' => 'id']);
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
