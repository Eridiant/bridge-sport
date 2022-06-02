<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%image_size}}".
 *
 * @property int $id
 * @property int $image_id
 * @property int|null $height
 * @property int|null $width
 *
 * @property Image $image
 */
class ImageSize extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image_size}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_id'], 'required'],
            [['image_id', 'height', 'width'], 'integer'],
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
            'height' => 'Height',
            'width' => 'Width',
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
