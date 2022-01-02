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
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
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
        return '{{%post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'active', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['description'], 'string'],
            [['created_at'], 'required'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
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
