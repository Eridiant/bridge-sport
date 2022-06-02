<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image as Imags;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property int $id
 * @property string|null $alt
 * @property string|null $url
 *
 * @property Iframe[] $iframes
 * @property ImageFormat[] $imageFormats
 * @property ImageSize[] $imageSizes
 * @property Post[] $posts
 */
class Image extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alt'], 'string', 'max' => 255],
            [['url'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alt' => 'Alt',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Iframes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIframes()
    {
        return $this->hasMany(Iframe::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[Youtubes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYoutubes()
    {
        return $this->hasMany(Youtube::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[ImageFormats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageFormats()
    {
        return $this->hasMany(ImageFormat::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[ImageSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageSizes()
    {
        return $this->hasMany(ImageSize::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['image_id' => 'id']);
    }

    public function upload($modPath, $format = 0){

        if($this->validate()){
            if (!empty($this->url)) {
                $arr = [];
                $year = date('Y');
                $month = date('m');

                if (!FileHelper::findDirectories(Yii::getAlias("@frontend/web/images/post/", $year))) {
                    FileHelper::createDirectory("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}", $mode = 0775);
                }
                if (!FileHelper::findDirectories(Yii::getAlias("@frontend/web/images/{$modPath}/{$year}/", $month))) {
                    FileHelper::createDirectory("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}/{$month}", $mode = 0775);
                }
                $rand = substr(md5(microtime() . rand(0, 9999)), 0, 5);
                $file_name_g = "{$modPath}/{$year}/{$month}/{$rand}-" . $this->url->baseName . '.' . $this->url->extension;
                $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/web/images/" . $file_name_g;
                $this->url->saveAs($path);
                $arr['path'] = $file_name_g;
                // $imagine = new Image();

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->url->baseName}.jpeg", ['jpeg_quality' => 75]);

                if (function_exists('imagewebp')) {
                    Imags::resize($path, 300, 100)
                    ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}/{$month}/{$rand}-{$this->url->baseName}.webp", ['webp_quality' => 75]);
                    $arr['webp'] = true;
                } else {
                    // var_dump('<pre>');
                    // var_dump(phpinfo());
                    // var_dump('</pre>');
                    // die;
                    
                }

                if (!$format) {
                    // Imags::thumbnail($path, 100, 100)
                    //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}/{$month}/{$rand}-{$this->url->baseName}.jpeg", ['jpeg_quality' => 75]);
                    Imags::thumbnail($path, 100, 100)
                    ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}/{$month}/{$rand}-{$this->url->baseName}-.jpg", ['quality' => 80]);
                    $arr['jpg'] = true;
                }

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->url->baseName}.jpeg", ['jpeg_quality' => 75]);

                return $file_name_g;
            }
            
        }else{
            return false;
        }
    }
}
