<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "{{%post}}".
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
 * @property int $indexing
 * @property string|null $keywords
 * @property int $active
 * @property int|null $author_id
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
            [['category_id', 'indexing', 'active', 'author_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['url', 'preview', 'description'], 'string'],
            [['taxonomiesArray'], 'safe'],
            [['name', 'slug', 'dial', 'keywords'], 'string', 'max' => 255],
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
            'indexing' => 'Indexing',
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
     * @return \yii\db\ActiveQuery|\backend\models\query\CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[PostTaxonomies]].
     *
     * @return \yii\db\ActiveQuery|\backend\models\query\PostTaxonomyQuery
     */
    public function getPostTaxonomies()
    {
        return $this->hasMany(PostTaxonomy::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Taxonomies]].
     *
     * @return \yii\db\ActiveQuery|\backend\models\query\TaxonomyQuery
     */
    public function getTaxonomies()
    {
        return $this->hasMany(Taxonomy::class, ['id' => 'taxonomy_id'])->viaTable('{{%post_taxonomy}}', ['post_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\PostQuery(get_called_class());
    }

    private $_taxonomiesArray;

    public function getTaxonomiesArray()
    {
        if ($this->_taxonomiesArray === null) {
            $this->_taxonomiesArray = $this->getTaxonomies()->select('id')->column();
        }
        return $this->_taxonomiesArray;
    }

    public function setTaxonomiesArray($value)
    {
        $this->_taxonomiesArray = (array)$value;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateTaxonomies();
        parent::afterSave($insert, $changedAttributes);
    }

    private function updateTaxonomies()
    {
        $currentTaxonomyIds = $this->getTaxonomies()->select('id')->column();
        $newTaxonomyIds = $this->getTaxonomiesArray();

        foreach (array_filter(array_diff($newTaxonomyIds, $currentTaxonomyIds)) as $taxonomyId) {
            /** @var Taxonomy $Taxonomy */
            if ($taxonomy = Taxonomy::findOne($taxonomyId)) {
                $this->link('taxonomies', $taxonomy);
            }
        }

        foreach (array_filter(array_diff($currentTaxonomyIds, $newTaxonomyIds)) as $taxonomyId) {
            /** @var Taxonomy $taxonomy */
            if ($taxonomy = Taxonomy::findOne($taxonomyId)) {
                $this->unlink('taxonomies', $taxonomy, true);
            }
        }
    }

    public function upload(){
        if($this->validate()){
            if (!empty($this->img)) {
                $year = date('Y');
                $month = date('m');

                if (!FileHelper::findDirectories(Yii::getAlias("@frontend/web/images/post/", $year))) {
                    FileHelper::createDirectory("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}", $mode = 0775);
                }
                if (!FileHelper::findDirectories(Yii::getAlias("@frontend/web/images/post/{$year}/", $month))) {
                    FileHelper::createDirectory("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}", $mode = 0775);
                }
                $rand = substr(md5(microtime() . rand(0, 9999)), 0, 5);
                $file_name_g = "{$year}/{$month}/{$rand}-" . $this->img->baseName . '.' . $this->img->extension;
                $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/web/images/post/" . $file_name_g;
                $this->img->saveAs($path);

                // $imagine = new Image();

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->img->baseName}.jpeg", ['jpeg_quality' => 75]);

                if (function_exists('imagewebp')) {
                    Image::resize($path, 300, 100)
                    ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->img->baseName}.webp", ['webp_quality' => 75]);
                } else {
                    // var_dump('<pre>');
                    // var_dump(phpinfo());
                    // var_dump('</pre>');
                    // die;
                    
                }
                Image::thumbnail($path, 100, 100)
                    ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->img->baseName}.jpeg", ['jpeg_quality' => 75]);

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->img->baseName}.jpeg", ['jpeg_quality' => 75]);

                return $file_name_g;
            }
            
        }else{
            return false;
        }
    }
}
