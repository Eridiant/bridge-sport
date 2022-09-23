<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%syst}}".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property SysItm[] $sysItms
 */
class Syst extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%syst}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'created_at'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[SysItms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSysItms()
    {
        return $this->hasMany(SysItm::class, ['syst_id' => 'id']);
    }
}
