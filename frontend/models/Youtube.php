<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%youtube}}".
 *
 * @property int $id
 * @property int|null $image_id
 * @property string|null $youtube
 * @property string|null $key
 * @property int|null $hide
 *
 * @property Image $image
 * @property Post[] $posts
 */
class Youtube extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%youtube}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_id', 'hide'], 'integer'],
            [['youtube'], 'string'],
            [['key'], 'string', 'max' => 127],
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
            'youtube' => 'Youtube',
            'key' => 'Key',
            'hide' => 'Hide',
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

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['youtube_id' => 'id']);
    }
}
