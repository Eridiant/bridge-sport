<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
// use yii\imagine\Image;


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
 * @property int|null $image_id
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
            [['category_id', 'name', 'slug'], 'required'],
            [['category_id', 'parent_id', 'image_id', 'iframe_id', 'youtube_id', 'indexing', 'status', 'author_id', 'published_at', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['url', 'preview', 'text', 'iframe', 'description'], 'string'],
            [['taxonomiesArray', 'alt', 'img', 'youtube', 'youtubeFields', 'hide', 'onlyImg', 'frame', 'previews'], 'safe'],
            [['name', 'slug', 'dial', 'title', 'keywords'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['iframe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iframe::class, 'targetAttribute' => ['iframe_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
            [['youtube_id'], 'exist', 'skipOnError' => true, 'targetClass' => Youtube::class, 'targetAttribute' => ['youtube_id' => 'id']],
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
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'url' => 'Url',
            'slug' => 'Slug',
            'preview' => 'Preview',
            'text' => 'Text',
            'image_id' => 'Image ID',
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
            'youtubeFields' => 'Ссылка на ютуб',
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
     * Gets query for [[Iframe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIframe()
    {
        return $this->hasOne(Iframe::class, ['id' => 'iframe_id']);
    }


    private $_iframe;
    private $_onlyImg;
    private $_preview;
    public function getFrame()
    {
        return $this->_iframe;
    }
    public function setFrame($value)
    {
        $this->_iframe = $value;
    }
    public function getOnlyImg()
    {
        return $this->_onlyImg;
    }
    public function setOnlyImg($value)
    {
        $this->_onlyImg = $value;
    }
    public function getPreviews()
    {
        return $this->_preview;
    }
    public function setPreviews($value)
    {
        $this->_preview = $value;
    }

    public function updateFrame()
    {
        if ($this->iframe) {
            $iframe = new Iframe();
            $iframe->frame = $this->getFrame();
            $iframe->only_img = $this->getOnlyImg();
            $iframe->preview = $this->getPreviews();
            if ($iframe->save()) {
                $this->iframe_id = $iframe->getPrimaryKey();
            } else {
                var_dump('<pre>');
                var_dump($iframe->getErrors());
                var_dump('</pre>');
                die;
            }
        }
    }

    private $_img;
    private $_alt;
    public function getImg()
    {
        return $this->_img;
    }
    public function setImg($value)
    {
        $this->_img = $value;
    }
    public function getAlt()
    {
        return $this->_alt;
    }
    public function setAlt($value)
    {
        $this->_alt = $value;
    }
    public function updateImage()
    {
        $image = new Image();
        $image->path = UploadedFile::getInstance($this, 'img');

        if ($arr = $image->upload('post')) {

            // var_dump('<pre>');
            // var_dump($arr);
            // var_dump('</pre>');
            // die;
            foreach ($arr as $key => $value) {
                $image->$key = $value;
            }
            // $image = new Image();
            // $image->url = $filename;
            $image->alt = $this->getAlt();
            
            if ($image->save()) {
                $this->image_id = $image->getPrimaryKey();
            } else {
                var_dump('<pre>');
                var_dump($image->getErrors());
                var_dump('</pre>');
                die;
            }
        }
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
     * Gets query for [[Youtube]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYoutube()
    {
        return $this->hasOne(Youtube::class, ['id' => 'youtube_id']);
    }


    // private $_youtube;
    private $_youtubeFields;
    public function getYoutubeFields()
    {
        if ($this->_youtubeFields === null) {
            $this->_youtubeFields = $this->getYoutube()->select('id')->one();
        }
        return $this->_youtubeFields;
    }

    private $_hide;
    public function getHide()
    {
        return $this->_hide;
    }

    public function setYoutubeFields($value)
    {
        $this->_youtubeFields = $value;
    }
    public function setHide($value)
    {
        $this->_hide = $value;
    }

    public function beforeSave($insert)
    {
        $this->updateImage();
        $this->updateYoutube();
        $this->updateFrame();
        // var_dump('<pre>');
        // var_dump($this);
        // var_dump('</pre>');
        // die;
        
        return parent::beforeSave($insert);
    }

    public function updateYoutube()
    {
        if ($this->youtube) {
            $youtube = new Youtube();
            $youtube->youtube = $this->getYoutubeFields();
            $youtube->hide = $this->getHide();
            $youtube->key = 'key';
            $youtube->image_id = 2;
            if ($youtube->save()) {
                $this->youtube_id = $youtube->getPrimaryKey();
            } else {
                var_dump('<pre>');
                var_dump($youtube->getErrors());
                var_dump('</pre>');
                die;
            }
        }
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

    // public function upload(){

    //     if($this->validate()){
    //         if (!empty($this->img)) {
    //             $year = date('Y');
    //             $month = date('m');

    //             if (!FileHelper::findDirectories(Yii::getAlias("@frontend/web/images/post/", $year))) {
    //                 FileHelper::createDirectory("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}", $mode = 0775);
    //             }
    //             if (!FileHelper::findDirectories(Yii::getAlias("@frontend/web/images/post/{$year}/", $month))) {
    //                 FileHelper::createDirectory("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}", $mode = 0775);
    //             }
    //             $rand = substr(md5(microtime() . rand(0, 9999)), 0, 5);
    //             $file_name_g = "{$year}/{$month}/{$rand}-" . $this->img->baseName . '.' . $this->img->extension;
    //             $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/web/images/post/" . $file_name_g;
    //             $this->img->saveAs($path);

    //             // $imagine = new Image();

    //             // Image::resize($path, 300, 100)
    //             //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->img->baseName}.jpeg", ['jpeg_quality' => 75]);

    //             if (function_exists('imagewebp')) {
    //                 Image::resize($path, 300, 100)
    //                 ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->img->baseName}.webp", ['webp_quality' => 75]);
    //             } else {
    //                 // var_dump('<pre>');
    //                 // var_dump(phpinfo());
    //                 // var_dump('</pre>');
    //                 // die;
                    
    //             }
    //             Image::thumbnail($path, 100, 100)
    //                 ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->img->baseName}.jpeg", ['jpeg_quality' => 75]);

    //             // Image::resize($path, 300, 100)
    //             //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->img->baseName}.jpeg", ['jpeg_quality' => 75]);

    //             return $file_name_g;
    //         }
            
    //     }else{
    //         return false;
    //     }
    // }
}
