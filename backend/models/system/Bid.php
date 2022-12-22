<?php

namespace backend\models\system;

use Yii;

/**
 * This is the model class for table "{{%bid}}".
 *
 * @property int $id
 * @property int $system_id
 * @property int $bid_tbl_id
 * @property int $parent_id
 * @property int|null $variant_id
 * @property int|null $vulnerable_id
 * @property int|null $pass
 * @property int|null $alert
 * @property string|null $excerpt
 * @property string|null $description
 * @property int|null $updated_at
 * @property int $created_at
 * @property int|null $deprecated_at
 *
 * @property BidTbl $bidTbl
 * @property System $system
 * @property UserBidRating[] $userBidRatings
 * @property Variant $variant
 * @property Vulnerable $vulnerable
 */
class Bid extends \yii\db\ActiveRecord
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
            [['system_id', 'bid_tbl_id', 'created_at'], 'required'],
            [['system_id', 'bid_tbl_id', 'parent_id', 'variant_id', 'vulnerable_id', 'deprecated_at', 'pass', 'alert', 'updated_at', 'created_at'], 'integer'],
            [['excerpt', 'description'], 'string'],
            [['bid_tbl_id'], 'exist', 'skipOnError' => true, 'targetClass' => BidTbl::class, 'targetAttribute' => ['bid_tbl_id' => 'id']],
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
            'bid_tbl_id' => 'Bid Tbl ID',
            'parent_id' => 'Parent ID',
            'variant_id' => 'Variant ID',
            'vulnerable_id' => 'Vulnerable ID',
            'pass' => 'Pass',
            'alert' => 'Alert',
            'excerpt' => 'Excerpt',
            'description' => 'Description',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'deprecated_at' => 'Deprecated At',
        ];
    }

    /**
     * Gets query for [[BidTbl]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBidTbl()
    {
        return $this->hasOne(BidTbl::class, ['id' => 'bid_tbl_id']);
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
     * Gets query for [[UserBidRatings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserBidRatings()
    {
        return $this->hasMany(UserBidRating::class, ['bid_id' => 'id']);
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
