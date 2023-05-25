<?php

namespace frontend\models;

use Yii;
use frontend\models\poll\Poll;

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
 * @property int $comments_status
 * @property int|null $survey_id
 * @property int|null $comments_hide
 *
 * @property Category $category
 * @property Iframe $iframe
 * @property Image $image
 * @property Message[] $messages
 * @property PostTaxonomy[] $postTaxonomies
 * @property Survey $survey
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
            [['category_id', 'parent_id', 'thread_id', 'image_id', 'image_header', 'iframe_id', 'youtube_id', 'indexing', 'status', 'author_id', 'published_at', 'created_at', 'updated_at', 'deleted_at', 'comments_status', 'comments_hide', 'survey_id'], 'integer'],
            [['url', 'preview', 'text', 'description'], 'string'],
            [['name', 'slug', 'dial', 'title', 'keywords'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['iframe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iframe::class, 'targetAttribute' => ['iframe_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
            [['youtube_id'], 'exist', 'skipOnError' => true, 'targetClass' => Youtube::class, 'targetAttribute' => ['youtube_id' => 'id']],
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
            'comments_status' => 'Comments Status',
            'survey_id' => 'Survey ID',
            'comments_hide' => 'Comments Hide',
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
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['post_id' => 'id']);
    }

    public function getReplies()
    {
        return $this->hasMany(Message::class, ['post_id' => 'id'])
            ->viaTable(MessageReply::class, ['message_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('{{%message}}', ['post_id' => 'id']);
        // $this->hasMany(Taxonomy::class, ['id' => 'taxonomy_id'])->viaTable('{{%post_taxonomy}}', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Polls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Poll::class, ['post_id' => 'id'])->andWhere(['active' => 1]);
    }

    /**
     * Gets query for [[Iframe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIframe()
    {
        return $this->hasOne(Iframe::class, ['id' => 'iframe_id']);
    }

    /**
     * Gets query for [[PollUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPollUsers()
    {
        return $this->hasMany(PollUser::class, ['poll_id' => 'id']);
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
     * Gets query for [[Survey]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurvey()
    {
        return $this->hasOne(Survey::class, ['id' => 'survey_id']);
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

    /**
     * Gets query for [[Youtube]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYoutube()
    {
        return $this->hasOne(Youtube::class, ['id' => 'youtube_id']);
    }
}
