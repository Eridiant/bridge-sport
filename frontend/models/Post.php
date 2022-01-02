<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "bsip_post".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $img
 * @property string|null $keywords
 * @property int $active
 *
 * @property Category $category
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bsip_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'active'], 'integer'],
            [['description'], 'string'],
            [['name', 'slug', 'img', 'keywords'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'img' => 'Img',
            'keywords' => 'Keywords',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
