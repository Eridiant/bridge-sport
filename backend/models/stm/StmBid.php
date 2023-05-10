<?php

namespace backend\models\stm;

use Yii;

/**
 * This is the model class for table "bsip_stm_bid".
 *
 * @property int $id
 * @property int $system_id
 * @property int $parent_id
 * @property int|null $variant_id
 * @property int|null $vulnerable_id
 * @property int $pass
 * @property int|null $hide
 * @property int|null $alert
 * @property int|null $opponent
 * @property string|null $excerpt
 * @property string|null $description
 * @property int|null $updated_at
 * @property int $created_at
 * @property int|null $deprecated_at
 *
 * @property StmBid[] $bids
 * @property StmBid[] $parents
 * @property StmBidStmBidTbl[] $stmBidStmBidTbls
 * @property StmBidStmBid[] $stmBidStmBs
 * @property StmBidStmBid[] $stmBidStmBs0
 * @property StmBidTbl[] $stmBidTbls
 * @property StmSystem $system
 * @property StmVariant $variant
 * @property StmVulnerable $vulnerable
 */
class StmBid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bsip_stm_bid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['system_id', 'created_at'], 'required'],
            [['system_id', 'parent_id', 'variant_id', 'vulnerable_id', 'pass', 'hide', 'alert', 'opponent', 'updated_at', 'created_at', 'deprecated_at'], 'integer'],
            [['excerpt', 'description'], 'string'],
            [['system_id'], 'exist', 'skipOnError' => true, 'targetClass' => StmSystem::class, 'targetAttribute' => ['system_id' => 'id']],
            [['variant_id'], 'exist', 'skipOnError' => true, 'targetClass' => StmVariant::class, 'targetAttribute' => ['variant_id' => 'id']],
            [['vulnerable_id'], 'exist', 'skipOnError' => true, 'targetClass' => StmVulnerable::class, 'targetAttribute' => ['vulnerable_id' => 'id']],
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
            'parent_id' => 'Parent ID',
            'variant_id' => 'Variant ID',
            'vulnerable_id' => 'Vulnerable ID',
            'pass' => 'Pass',
            'hide' => 'Hide',
            'alert' => 'Alert',
            'opponent' => 'Opponent',
            'excerpt' => 'Excerpt',
            'description' => 'Description',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'deprecated_at' => 'Deprecated At',
        ];
    }

    /**
     * Gets query for [[Bids]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBids()
    {
        return $this->hasMany(StmBid::class, ['id' => 'bid_id'])->viaTable('bsip_stm_bid_stm_bid', ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[Parents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(StmBid::class, ['id' => 'parent_id'])->viaTable('bsip_stm_bid_stm_bid', ['bid_id' => 'id']);
    }

    /**
     * Gets query for [[StmBidStmBidTbls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmBidStmBidTbls()
    {
        return $this->hasMany(StmBidStmBidTbl::class, ['stm_bid_id' => 'id']);
    }

    /**
     * Gets query for [[StmBidStmBs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmBidStmBs()
    {
        return $this->hasMany(StmBidStmBid::class, ['bid_id' => 'id']);
    }

    /**
     * Gets query for [[StmBidStmBs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmBidStmBs0()
    {
        return $this->hasMany(StmBidStmBid::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[StmBidTbls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmBidTbls()
    {
        return $this->hasMany(StmBidTbl::class, ['id' => 'stm_bid_tbl_id'])->viaTable('bsip_stm_bid_stm_bid_tbl', ['stm_bid_id' => 'id']);
    }

    /**
     * Gets query for [[System]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystem()
    {
        return $this->hasOne(StmSystem::class, ['id' => 'system_id']);
    }

    /**
     * Gets query for [[Variant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariant()
    {
        return $this->hasOne(StmVariant::class, ['id' => 'variant_id']);
    }

    /**
     * Gets query for [[Vulnerable]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVulnerable()
    {
        return $this->hasOne(StmVulnerable::class, ['id' => 'vulnerable_id']);
    }
}
