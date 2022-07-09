<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int|null $parent_id
 * @property int|null $thread_id
 * @property string $name
 * @property string|null $url
 * @property string $slug
 * @property string|null $preview
 * @property string|null $text
 * @property int|null $image_id
 * @property int $image_header
 * @property string|null $dial
 * @property int|null $iframe_id
 * @property int|null $youtube_id
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
 * @property Iframe $iframe
 * @property Image $image
 * @property PostTaxonomy[] $postTaxonomies
 * @property Taxonomy[] $taxonomies
 * @property Youtube $youtube
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
            [['category_id', 'name', 'slug', 'created_at'], 'required'],
            [['category_id', 'parent_id', 'thread_id', 'image_id', 'image_header', 'iframe_id', 'youtube_id', 'indexing', 'status', 'author_id', 'published_at', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['url', 'preview', 'text', 'description'], 'string'],
            [['name', 'slug', 'dial', 'title', 'keywords'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['iframe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iframe::className(), 'targetAttribute' => ['iframe_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['youtube_id'], 'exist', 'skipOnError' => true, 'targetClass' => Youtube::className(), 'targetAttribute' => ['youtube_id' => 'id']],
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
            'thread_id' => 'Thread ID',
            'name' => 'Name',
            'url' => 'Url',
            'slug' => 'Slug',
            'preview' => 'Preview',
            'text' => 'Text',
            'image_id' => 'Image ID',
            'image_header' => 'Image Header',
            'dial' => 'Dial',
            'iframe_id' => 'Iframe ID',
            'youtube_id' => 'Youtube ID',
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
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Iframe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIframe()
    {
        return $this->hasOne(Iframe::className(), ['id' => 'iframe_id']);
    }

    /**
     * Gets query for [[Image]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * Gets query for [[PostTaxonomies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostTaxonomies()
    {
        return $this->hasMany(PostTaxonomy::className(), ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Taxonomies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaxonomies()
    {
        return $this->hasMany(Taxonomy::className(), ['id' => 'taxonomy_id'])->viaTable('{{%post_taxonomy}}', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Youtube]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYoutube()
    {
        return $this->hasOne(Youtube::className(), ['id' => 'youtube_id']);
    }
}
