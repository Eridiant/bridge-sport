<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bsip_category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string|null $img
 * @property string|null $keywords
 * @property string|null $description
 * @property int $active
 * @property int|null $deleted_at
 *
 * @property Post[] $posts
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'active', 'deleted_at'], 'integer'],
            [['name', 'slug'], 'required'],
            [ 'parent_id', 'default', 'value' => 0 ],
            [['description'], 'string'],
            [['name', 'slug', 'img', 'keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'img' => 'Img',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'active' => 'Active',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['category_id' => 'id']);
    }
}

