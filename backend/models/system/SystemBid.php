<?php

namespace backend\models\system;

use Yii;

/**
 * This is the model class for table "{{%bid}}".
 *
 * @property int $id
 * @property int $system_id
 * @property int $bid_id
 * @property int $parent_id
 * @property int|null $answer_id
 * @property int|null $variant_id
 * @property int|null $vulnerable_id
 * @property string|null $excerpt
 * @property string|null $description
 * @property int|null $updated_at
 * @property int $created_at
 *
 * @property Bid $bid
 * @property System $system
 * @property Variant $variant
 * @property Vulnerable $vulnerable
 */
class SystemBid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bid}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['system_id', 'bid_id', 'created_at'], 'required'],
            [['system_id', 'bid_id', 'parent_id', 'answer_id', 'variant_id', 'vulnerable_id', 'updated_at', 'created_at'], 'integer'],
            [['excerpt', 'description'], 'string'],
            [['bid_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bid::class, 'targetAttribute' => ['bid_id' => 'id']],
            [['system_id'], 'exist', 'skipOnError' => true, 'targetClass' => System::class, 'targetAttribute' => ['system_id' => 'id']],
            [['variant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Variant::class, 'targetAttribute' => ['variant_id' => 'id']],
            [['vulnerable_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vulnerable::class, 'targetAttribute' => ['vulnerable_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'system_id' => 'System ID',
            'bid_id' => 'Bid ID',
            'parent_id' => 'Parent ID',
            'answer_id' => 'Answer ID',
            'variant_id' => 'Variant ID',
            'vulnerable_id' => 'Vulnerable ID',
            'excerpt' => 'Excerpt',
            'description' => 'Description',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Bid]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBid()
    {
        return $this->hasOne(Bid::class, ['id' => 'bid_id']);
    }

    /**
     * Gets query for [[System]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystem()
    {
        return $this->hasOne(System::class, ['id' => 'system_id']);
    }

    /**
     * Gets query for [[Variant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariant()
    {
        return $this->hasOne(Variant::class, ['id' => 'variant_id']);
    }

    /**
     * Gets query for [[Vulnerable]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVulnerable()
    {
        return $this->hasOne(Vulnerable::class, ['id' => 'vulnerable_id']);
    }
}
