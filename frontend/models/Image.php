<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property int $id
 * @property string|null $alt
 * @property string|null $path
 * @property int|null $thWidth
 * @property int|null $thHeight
 * @property string|null $format
 * @property int|null $thumb
 * @property int|null $width
 * @property int|null $height
 * @property int|null $image
 *
 * @property Iframe[] $iframes
 * @property Post[] $posts
 * @property Youtube[] $youtubes
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thWidth', 'thHeight', 'thumb', 'width', 'height', 'image'], 'integer'],
            [['alt', 'path'], 'string', 'max' => 255],
            [['format'], 'string', 'max' => 24],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alt' => 'Alt',
            'path' => 'Path',
            'thWidth' => 'Th Width',
            'thHeight' => 'Th Height',
            'format' => 'Format',
            'thumb' => 'Thumb',
            'width' => 'Width',
            'height' => 'Height',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[Iframes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIframes()
    {
        return $this->hasMany(Iframe::className(), ['image_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['image_id' => 'id']);
    }

    /**
     * Gets query for [[Youtubes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYoutubes()
    {
        return $this->hasMany(Youtube::className(), ['image_id' => 'id']);
    }
}
