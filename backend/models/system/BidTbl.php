<?php

namespace backend\models\system;

use Yii;

/**
 * This is the model class for table "{{%bid_tbl}}".
 *
 * @property int $id
 * @property int $lvl
 * @property string|null $bid
 * @property string|null $img
 * @property int $type
 *
 * @property Bid[] $bs
 */
class BidTbl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bid_tbl}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lvl', 'type'], 'integer'],
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
            'bid' => 'Bid',
            'img' => 'Img',
            'type' => 'Type',
        ];
    }

    /**
     * Gets query for [[Bs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBs()
    {
        return $this->hasMany(Bid::class, ['bid_tbl_id' => 'id']);
    }
}
