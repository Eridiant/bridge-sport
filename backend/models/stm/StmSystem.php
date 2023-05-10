<?php

namespace backend\models\stm;

use Yii;
use yii\behaviors\TimestampBehavior;
use backend\models\User;

/**
 * This is the model class for table "bsip_stm_system".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $hidden
 * @property int $edit
 * @property int|null $updated_at
 * @property int $created_at
 *
 * @property StmSystem[] $conventions
 * @property StmBid[] $stmBids
 * @property StmSystemStmSystem[] $stmSystemStmSystems
 * @property StmSystemStmSystem[] $stmSystemStmSystems0
 * @property StmSystem[] $systems
 * @property User $user
 */
class StmSystem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stm_system}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'hidden', 'edit', 'updated_at', 'created_at'], 'integer'],
            [['name', 'slug'], 'required'],
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
        return $this->hasMany(StmSystem::class, ['id' => 'convention_id'])->viaTable('bsip_stm_system_stm_system', ['system_id' => 'id']);
    }

    /**
     * Gets query for [[StmBs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmBids()
    {
        return $this->hasMany(StmBid::class, ['system_id' => 'id']);
    }

    /**
     * Gets query for [[StmSystemStmSystems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmSystemStmSystems()
    {
        return $this->hasMany(StmSystemStmSystem::class, ['convention_id' => 'id']);
    }

    /**
     * Gets query for [[StmSystemStmSystems0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmSystemStmSystems0()
    {
        return $this->hasMany(StmSystemStmSystem::class, ['system_id' => 'id']);
    }

    /**
     * Gets query for [[Systems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystems()
    {
        return $this->hasMany(StmSystem::class, ['id' => 'system_id'])->viaTable('bsip_stm_system_stm_system', ['convention_id' => 'id']);
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
