<?php

namespace frontend\models;

use Yii;


/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $url
 * @property string $slug
 * @property string|null $preview
 * @property string|null $text
 * @property string|null $img
 * @property string|null $dial
 * @property string|null $iframe
 * @property int $indexing
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keywords
 * @property int $status
 * @property int|null $author_id
 * @property int|null $published_at
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Category $category
 * @property PostTaxonomy[] $postTaxonomies
 * @property Taxonomy[] $taxonomies
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
            [['category_id', 'name', 'slug'], 'required'],
            [['category_id', 'parent_id', 'indexing', 'status', 'author_id', 'published_at', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['url', 'preview', 'text', 'description'], 'string'],
            [['name', 'slug', 'img', 'dial', 'iframe', 'title', 'keywords'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'url' => 'Url',
            'slug' => 'Slug',
            'preview' => 'Preview',
            'text' => 'Text',
            'img' => 'Img',
            'dial' => 'Dial',
            'iframe' => 'Iframe',
            'indexing' => 'Indexing',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'status' => 'Status',
            'author_id' => 'Author ID',
            'published_at' => 'Published At',
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

    /**
     * Gets query for [[PostTaxonomies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostTaxonomies()
    {
        return $this->hasMany(PostTaxonomy::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Taxonomies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaxonomies()
    {
        return $this->hasMany(Taxonomy::class, ['id' => 'taxonomy_id'])->viaTable('{{%post_taxonomy}}', ['post_id' => 'id']);
    }
}
