<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%sys_itm}}".
 *
 * @property int $id
 * @property int $syst_id
 * @property int $parent_id
 * @property int|null $answer_id
 * @property int|null $lvl
 * @property string|null $description
 *
 * @property Syst $syst
 */
class SysItm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sys_itm}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['syst_id'], 'required'],
            [['syst_id', 'parent_id', 'answer_id', 'lvl'], 'integer'],
            [['description'], 'string'],
            [['syst_id'], 'exist', 'skipOnError' => true, 'targetClass' => Syst::class, 'targetAttribute' => ['syst_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'syst_id' => 'Syst ID',
            'parent_id' => 'Parent ID',
            'answer_id' => 'Answer ID',
            'lvl' => 'Lvl',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Syst]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSyst()
    {
        return $this->hasOne(Syst::class, ['id' => 'syst_id']);
    }
}
