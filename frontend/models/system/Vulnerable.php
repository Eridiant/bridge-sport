<?php

namespace frontend\models\system;

use Yii;

/**
 * This is the model class for table "{{%vulnerable}}".
 *
 * @property int $id
 * @property int|null $vulnerable
 * @property string|null $vulnerable_desc
 *
 * @property Bid[] $bs
 */
class Vulnerable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vulnerable}}';
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
     * Gets query for [[Bs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBids()
    {
        return $this->hasMany(Bid::class, ['vulnerable_id' => 'id']);
    }
}
