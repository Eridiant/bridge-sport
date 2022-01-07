<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "bsip_post".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $url
 * @property string $slug
 * @property string|null $preview
 * @property string|null $description
 * @property string|null $img
 * @property string|null $dial
 * @property string|null $keywords
 * @property int $active
 * @property int|null $author_id
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Category $category
 */
class Post extends \yii\db\ActiveRecord
{

    public $createdAtAttribute = 'created_at';
    public $updatedAtAttribute = 'updated_at';

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
            [['category_id', 'active', 'author_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['url', 'preview', 'description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'slug', 'img', 'dial', 'keywords'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // 'value' => new \yii\db\Expression('NOW()'),
            ],
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
            'url' => 'Url',
            'slug' => 'Slug',
            'preview' => 'Preview',
            'description' => 'Description',
            'img' => 'Img',
            'dial' => 'Dial',
            'keywords' => 'Keywords',
            'active' => 'Active',
            'author_id' => 'Author ID',
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
