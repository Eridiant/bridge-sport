<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%image_format}}".
 *
 * @property int $id
 * @property int $image_id
 * @property string|null $format
 *
 * @property Image $image
 */
class ImageFormat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image_format}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_id'], 'required'],
            [['image_id'], 'integer'],
            [['format'], 'string', 'max' => 24],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_id' => 'Image ID',
            'format' => 'Format',
        ];
    }

    /**
     * Gets query for [[Image]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
}
