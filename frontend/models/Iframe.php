<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%iframe}}".
 *
 * @property int $id
 * @property int|null $image_id
 * @property string|null $frame
 * @property int|null $only_img
 * @property int|null $preview
 *
 * @property Image $image
 * @property Post[] $posts
 */
class Iframe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%iframe}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_id', 'only_img', 'preview'], 'integer'],
            [['frame'], 'string'],
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
            'frame' => 'Frame',
            'only_img' => 'Only Img',
            'preview' => 'Preview',
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
        return $this->hasMany(Post::class, ['iframe_id' => 'id']);
    }
}
