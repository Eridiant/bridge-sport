<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property int $id
 * @property string|null $alt
 * @property string|null $url
 *
 * @property Iframe[] $iframes
 * @property ImageFormat[] $imageFormats
 * @property ImageSize[] $imageSizes
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
            [['alt', 'url'], 'string', 'max' => 255],
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
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Iframes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIframes()
    {
        return $this->hasMany(Iframe::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[ImageFormats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageFormats()
    {
        return $this->hasMany(ImageFormat::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[ImageSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageSizes()
    {
        return $this->hasMany(ImageSize::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[Youtubes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYoutubes()
    {
        return $this->hasMany(Youtube::class, ['image_id' => 'id']);
    }
}
