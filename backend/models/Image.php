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

    private $fixHeight;
    private $findHeight;
    public function upload($modPath, $format = 0, $fix = 0){

        $this->fixHeight = $fix;
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
                $rand = substr(md5(microtime() . rand(0, 9999)), 0, 7);
                $file_name_g = "{$modPath}/{$year}/{$month}/{$rand}-" . $this->url->baseName;
                $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/web/images/" . $file_name_g;
                $pathExt = "{$path}.{$this->url->extension}";
                $this->url->saveAs($pathExt);
                $arr['path'] = $file_name_g;
                // $imagine = new Image();

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->url->baseName}.jpeg", ['jpeg_quality' => 75]);

                $thWidth = 480;
                $thHeight = 335;
                if (!$format) {
                    $format = 'jpg';
                }
                $mult = $this->sizeCheck($pathExt, $thWidth, $thHeight);
                $this->thb($format, $path, 261, 182);
                $this->thb($format, $path, $thWidth, $thHeight);
                if ($mult >= 4) {
                    $this->thb($format, $path, $thWidth * 4, $thHeight * 4);
                    $mult = 4;
                }
                if ($mult >= 2) {
                    $this->thb($format, $path, $thWidth * 2, $thHeight * 2);
                    $mult = 2;
                } else {
                    $mult = 1;
                }

                if (function_exists('imagewebp')) {
                    $this->thb('webp', $path, $thWidth, $thHeight);
                    if ($mult >= 4) {
                        $this->thb('webp', $path, $thWidth * 4, $thHeight * 4);
                    }
                    if ($mult >= 2) {
                        $this->thb('webp', $path, $thWidth * 2, $thHeight * 2);
                    }
                    $arr['webp'] = true;
                }
                $arr['thWidth'] = $thWidth;
                $arr['thHeight'] = $thHeight;
                $arr['format'] = $format;
                $arr['thumb'] = $mult;

                // полный формат
                $width = 1178;
                $mult = $this->sizeCheck($pathExt, $width);
                $this->thb($format, $path, $width);
                if ($mult >= 4) {
                    $this->thb($format, $path, $width * 4);
                    $mult = 4;
                }
                if ($mult >= 2) {
                    $this->thb($format, $path, $width * 2);
                    $mult = 2;
                } else {
                    $mult = 1;
                }
                if (function_exists('imagewebp')) {
                    $this->thb('webp', $path, $width, $this->findHeight);
                    if ($mult >= 4) {
                        $this->thb('webp', $path, $width * 4, $this->findHeight * 4);
                    }
                    if ($mult >= 2) {
                        $this->thb('webp', $path, $width * 2, $this->findHeight * 2);
                    }
                    $arr['webp'] = true;
                }

                $arr['width'] = $width;
                $arr['height'] = $this->findHeight;
                $arr['image'] = $mult;

                // Imags::thumbnail($path, 100, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}/{$month}/{$rand}-{$this->url->baseName}.jpeg", ['jpeg_quality' => 75]);
                // Imags::thumbnail($path, 100, 100)
                // ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}/{$month}/{$rand}-{$this->url->baseName}-.jpg", ['quality' => 80]);

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->url->baseName}.jpeg", ['jpeg_quality' => 75]);

                return $arr;
            }
            
        }else{
            return false;
        }
    }

    private function sizeCheck($pathExt, $width, $height = 1)
    {
        $size = getimagesize($pathExt);
        $imageWidth = $size[0];
        $imageHeight = $size[1];
        if ($height === 1) {
            $height = intval($imageHeight / ($imageWidth / $width));
            if ($height < $width / 3) {
                $height = intval($width / 3);
            } elseif ($height > $width * 1 && !$this->fixHeight) {
                $height = intval($width * 1);
            }
            $this->findHeight = $height;
        }
        if ($width * 4 < $imageWidth && $height * 4 < $imageHeight) {
            return 4;
        } elseif ($width * 2 < $imageWidth && $height * 2 < $imageHeight) {
            return 2;
        }
        return 1;
    }

    private function thb($format, $path, $width, $height = 0)
    {
        switch ($format) {
            case 'jpeg':
            case 'jpg':
                $quality = ['jpeg_quality' => 80];
                break;
            case 'webp':
                $quality = ['webp_quality' => 80];
                break;
            case 'png':
                $quality = ['png_compression_level' => 9];
                break;
            default:
                $format = 'jpg';
                $quality = ['jpeg_quality' => 80];
                break;
        }
        if ($height) {
            Imags::thumbnail("{$path}.{$this->url->extension}", $width, $height)
                ->save("{$path}-{$width}x{$height}.{$format}", $quality);
        } else {
            Imags::thumbnail("{$path}.{$this->url->extension}", $width, $this->findHeight)
                ->save("{$path}-{$width}x{$this->findHeight}.{$format}", $quality);
        }
    }
}
