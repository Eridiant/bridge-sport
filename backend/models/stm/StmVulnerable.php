<?php

namespace backend\models\stm;

use Yii;

/**
 * This is the model class for table "bsip_stm_vulnerable".
 *
 * @property int $id
 * @property int|null $vulnerable
 * @property string|null $vulnerable_desc
 *
 * @property StmBid[] $stmBs
 */
class StmVulnerable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bsip_stm_vulnerable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vulnerable'], 'integer'],
            [['vulnerable_desc'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vulnerable' => 'Vulnerable',
            'vulnerable_desc' => 'Vulnerable Desc',
        ];
    }

    /**
     * Gets query for [[StmBs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStmBs()
    {
        return $this->hasMany(StmBid::class, ['vulnerable_id' => 'id']);
    }
}
