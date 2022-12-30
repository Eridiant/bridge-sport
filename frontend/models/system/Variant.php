<?php

namespace frontend\models\system;

use Yii;

/**
 * This is the model class for table "{{%variant}}".
 *
 * @property int $id
 * @property int|null $variant
 * @property string|null $variant_desc
 *
 * @property Bid[] $bs
 */
class Variant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%variant}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['variant'], 'integer'],
            [['variant_desc'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'variant' => 'Variant',
            'variant_desc' => 'Variant Desc',
        ];
    }

    /**
     * Gets query for [[Bs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBids()
    {
        return $this->hasMany(Bid::class, ['variant_id' => 'id']);
    }
}
