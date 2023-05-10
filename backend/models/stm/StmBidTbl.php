<?php

namespace backend\models\stm;

use Yii;

/**
 * This is the model class for table "bsip_stm_bid_tbl".
 *
 * @property int $id
 * @property int $lvl
 * @property int $num
 * @property string|null $bid
 * @property string|null $img
 *
 * @property StmBidStmBidTbl[] $stmBidStmBidTbls
 * @property StmBid[] $stmBids
 */
class StmBidTbl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bsip_stm_bid_tbl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lvl', 'num'], 'integer'],
            [['bid', 'img'], 'string', 'max' => 24],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lvl' => 'Lvl',
            'num' => 'Num',
            'bid' => 'Bid',
            'img' => 'Img',
        ];
    }

    /**
     * Gets query for [[StmBidStmBidTbls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmBidStmBidTbls()
    {
        return $this->hasMany(StmBidStmBidTbl::class, ['stm_bid_tbl_id' => 'id']);
    }

    /**
     * Gets query for [[StmBids]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmBids()
    {
        return $this->hasMany(StmBid::class, ['id' => 'stm_bid_id'])->viaTable('bsip_stm_bid_stm_bid_tbl', ['stm_bid_tbl_id' => 'id']);
    }
}
