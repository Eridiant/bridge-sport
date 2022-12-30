<?php

namespace frontend\models\system;

use Yii;

/**
 * This is the model class for table "{{%bid_tbl}}".
 *
 * @property int $id
 * @property int $lvl
 * @property int $scores
 * @property int $num
 * @property string|null $bid
 * @property string|null $img
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
            [['lvl', 'scores', 'num'], 'integer'],
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
            'scores' => 'Scores',
            'num' => 'Num',
            'bid' => 'Bid',
            'img' => 'Img',
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
