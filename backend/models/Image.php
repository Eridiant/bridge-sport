<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image as Imags;
use Imagine\Image\ImageInterface;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property int $id
 * @property string|null $alt
 * @property string|null $path
 * @property int|null $thWidth
 * @property int|null $thHeight
 * @property string|null $format
 * @property int|null $thumb
 * @property int|null $width
 * @property int|null $height
 * @property int|null $image
 *
 * @property Iframe[] $iframes
 * @property Post[] $posts
 * @property Youtube[] $youtubes
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
            [['thWidth', 'thHeight', 'thumb', 'width', 'height', 'image'], 'integer'],
            [['alt'], 'string', 'max' => 255],
            [['format', 'rand'], 'string', 'max' => 24],
            [['url', 'path'], 'safe']
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
            'path' => 'Path',
            'rand' => 'Rand',
            'thWidth' => 'Th Width',
            'thHeight' => 'Th Height',
            'format' => 'Format',
            'thumb' => 'Thumb',
            'width' => 'Width',
            'height' => 'Height',
            'image' => 'Image',
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
    // public function getImageFormats()
    // {
    //     return $this->hasMany(ImageFormat::class, ['image_id' => 'id']);
    // }

    /**
     * Gets query for [[ImageSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getImageSizes()
    // {
    //     return $this->hasMany(ImageSize::class, ['image_id' => 'id']);
    // }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['image_id' => 'id']);
    }

    private function checkFolder($modPath)
    {
        $year = date('Y');
        $month = date('m');

        if (!FileHelper::findDirectories(Yii::getAlias("@frontend/web/images/{$modPath}/", $year))) {
            FileHelper::createDirectory("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}", $mode = 0775);
        }
        if (!FileHelper::findDirectories(Yii::getAlias("@frontend/web/images/{$modPath}/{$year}/", $month))) {
            FileHelper::createDirectory("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}/{$month}", $mode = 0775);
        }
    }

    private function cropFrame($rand, $path)
    {
        $quality = ['jpeg_quality' => 80];
        $img = Imags::thumbnail(Yii::getAlias("@frontend/web/images/temp/{$rand}.jpg"), 897, 630);
        $img = Imags::frame($img, 152, 'fff', 100);
        Imags::crop($img, 1200, 630, [0, 152])
            // ->save(Yii::getAlias("@frontend/web/images/temp/{$rand}1.jpg"));
            ->save("{$path}-1200x630.jpg", $quality);
    }

    private function cropImage($pathExt, $rand, $width, $height)
    {
        // Обрежет по ширине u высоте
        Imags::crop($pathExt, $width, $height)
            ->save(Yii::getAlias("@frontend/web/images/temp/{$rand}.jpg"));
    }

    public function uploadFr($modPath, $key, $format = 0, $fix = 0)
    {
        $this->fixHeight = $fix;

        if(true){
            if (true) {
                $arr = [];
                $year = date('Y');
                $month = date('m');
                $this->checkFolder($modPath);
                
                $params = http_build_query(array(
                    "access_key" => Key::find()->where(['key' => 'access_key'])->one()->value,
                    "url" => $key,
                    // "css" => "",
                    "width" => "2383",
                    "height" => "1800",
                    "quality" => "100",
                ));
                
                $image_data = file_get_contents("https://api.apiflash.com/v1/urltoimage?" . $params);
                
                

                $rand = substr(md5(microtime() . rand(0, 9999)), 0, 7);
                $file_name_g = "{$modPath}/{$year}/{$month}/{$rand}";
                // $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/web/images/temp/{$rand}";
                // $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/web/images/" . $file_name_g;

                $path = Yii::getAlias("@frontend/web/images/{$file_name_g}");

                // for del
                // $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/web/images/temp/screenshot";
                // for del
                $pathExt = Yii::getAlias("@frontend/web/images/temp/{$rand}.jpeg");
                file_put_contents($pathExt, $image_data);

                // $this->path->saveAs($pathExt);
                $this->cropImage($pathExt, $rand, 2383, 1674);
                $pathExt = Yii::getAlias("@frontend/web/images/temp/{$rand}.jpg");

                $arr['rand'] = $rand;
                $arr['path'] = $file_name_g;
                // $imagine = new Image();

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->path->baseName}.jpeg", ['jpeg_quality' => 75]);

                $thWidth = 480;
                $thHeight = 335;
                if (!$format) {
                    $format = 'jpg';
                }
                $mult = $this->sizeCheck($pathExt, $thWidth, $thHeight);

                // img for admin
                $this->thb($format, $path, $pathExt, 261, 182);
                // img for social, поправить что бы вмещалось
                $this->cropFrame($rand, $path);
                // $this->thb('jpg', $path, $pathExt, 1200, 630);
                // img for mobaile
                $this->thb($format, $path, $pathExt, $thWidth, $thHeight);
                if ($mult >= 4) {
                    $this->thb($format, $path, $pathExt, $thWidth * 4, $thHeight * 4);
                    $mult = 4;
                }
                if ($mult >= 2) {
                    $this->thb($format, $path, $pathExt, $thWidth * 2, $thHeight * 2);
                    $mult = $mult === 4 ? 4 : 2;
                } else {
                    $mult = 1;
                }

                $arr['format'] = $format;

                if (function_exists('imagewebp')) {
                    $this->thb('webp', $path, $thWidth, $thHeight);
                    if ($mult >= 4) {
                        $this->thb('webp', $path, $thWidth * 4, $thHeight * 4);
                    }
                    if ($mult >= 2) {
                        $this->thb('webp', $path, $thWidth * 2, $thHeight * 2);
                    }
                    $arr['format'] = 'webp,'. $arr['format'];

                }
                $arr['thWidth'] = $thWidth;
                $arr['thHeight'] = $thHeight;
                $arr['thumb'] = $mult;

                // полный формат
                $width = 1178;
                $mult = $this->sizeCheck($pathExt, $width);
                $this->thb($format, $path, $pathExt, $width);
                if ($mult >= 4) {
                    $this->thb($format, $path, $pathExt, $width * 4, $this->findHeight * 4);
                    $mult = 4;
                }
                if ($mult >= 2) {
                    $this->thb($format, $path, $pathExt, $width * 2, $this->findHeight * 2);
                    $mult = $mult === 4 ? 4 : 2;
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

                return $arr;
            }
            
        }else{
            return false;
        }
    }

    public function uploadY($modPath, $key, $format = 0, $fix = 0)
    {
        $this->fixHeight = $fix;

        if(true){
            if (true) {
                $arr = [];
                $year = date('Y');
                $month = date('m');

                $this->checkFolder($modPath);

                $rand = substr(md5(microtime() . rand(0, 9999)), 0, 7);
                $file_name_g = "{$modPath}/{$year}/{$month}/{$rand}-{$key}";
                $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/web/images/" . $file_name_g;
                $pathExt = Yii::getAlias("@frontend/web/images/temp/{$rand}.jpg");
                file_put_contents($pathExt, file_get_contents("https://i.ytimg.com/vi/{$key}/maxresdefault.jpg"));
                // $pathExt = "{$path}.jpg";
                // $this->path->saveAs($pathExt);
                $arr['rand'] = $rand;
                $arr['path'] = $file_name_g;
                // $imagine = new Image();

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->path->baseName}.jpeg", ['jpeg_quality' => 75]);

                $thWidth = 480;
                $thHeight = 335;
                if (!$format) {
                    $format = 'jpg';
                }
                $mult = $this->sizeCheck($pathExt, $thWidth, $thHeight);

                // img for admin
                $this->thb($format, $path, $pathExt, 261, 182);
                // img for social, поправить что бы вмещалось
                $this->thb('jpg', $path, $pathExt, 1200, 630);
                // img for mobaile
                $this->thb($format, $path, $pathExt, $thWidth, $thHeight);
                if ($mult >= 4) {
                    $this->thb($format, $path, $pathExt, $thWidth * 4, $thHeight * 4);
                    $mult = 4;
                }
                if ($mult >= 2) {
                    $this->thb($format, $path, $pathExt, $thWidth * 2, $thHeight * 2);
                    $mult = $mult === 4 ? 4 : 2;
                } else {
                    $mult = 1;
                }

                $arr['format'] = $format;

                if (function_exists('imagewebp')) {
                    $this->thb('webp', $path, $thWidth, $thHeight);
                    if ($mult >= 4) {
                        $this->thb('webp', $path, $thWidth * 4, $thHeight * 4);
                    }
                    if ($mult >= 2) {
                        $this->thb('webp', $path, $thWidth * 2, $thHeight * 2);
                    }
                    $arr['format'] = 'webp,'. $arr['format'];

                }
                $arr['thWidth'] = $thWidth;
                $arr['thHeight'] = $thHeight;
                $arr['thumb'] = $mult;

                // полный формат
                $width = 1178;
                $mult = $this->sizeCheck($pathExt, $width);
                $this->thb($format, $path, $pathExt, $width);
                if ($mult >= 4) {
                    $this->thb($format, $path, $pathExt, $width * 4, $this->findHeight * 4);
                    $mult = 4;
                }
                if ($mult >= 2) {
                    $this->thb($format, $path, $pathExt, $width * 2, $this->findHeight * 2);
                    $mult = $mult === 4 ? 4 : 2;
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

                return $arr;
            }
            
        }else{
            return false;
        }
    }

    private $fixHeight;
    private $findHeight;
    public function upload($modPath, $format = 0, $fix = 0)
    {

        $this->fixHeight = $fix;
        if($this->validate()){
            if (!empty($this->path)) {
                $arr = [];
                $year = date('Y');
                $month = date('m');

                $this->checkFolder($modPath);

                $rand = substr(md5(microtime() . rand(0, 9999)), 0, 7);
                $file_name_g = "{$modPath}/{$year}/{$month}/{$rand}-" . $this->path->baseName;
                $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/web/images/" . $file_name_g;
                // $pathExt = "{$path}.{$this->path->extension}";
                $pathExt = Yii::getAlias("@frontend/web/images/temp/{$rand}.{$this->path->extension}");
                $this->path->saveAs($pathExt);

                $arr['rand'] = $rand;
                $arr['path'] = $file_name_g;
                // $imagine = new Image();

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->path->baseName}.jpeg", ['jpeg_quality' => 75]);

                $thWidth = 480;
                $thHeight = 335;
                if (!$format) {
                    $format = 'jpg';
                }
                $mult = $this->sizeCheck($pathExt, $thWidth, $thHeight);

                // img for admin
                $this->thb($format, $path, $pathExt, 261, 182);
                // img for social, поправить что бы вмещалось
                $this->thb('jpg', $path, $pathExt, 1200, 630);
                // img for mobaile
                $this->thb($format, $path, $pathExt, $thWidth, $thHeight);
                if ($mult >= 4) {
                    $this->thb($format, $path, $pathExt, $thWidth * 4, $thHeight * 4);
                    $mult = 4;
                }
                if ($mult >= 2) {
                    $this->thb($format, $path, $pathExt, $thWidth * 2, $thHeight * 2);
                    $mult = $mult === 4 ? 4 : 2;
                } else {
                    $mult = 1;
                }

                $arr['format'] = $format;

                if (function_exists('imagewebp')) {
                    $this->thb('webp', $path, $thWidth, $thHeight);
                    if ($mult >= 4) {
                        $this->thb('webp', $path, $thWidth * 4, $thHeight * 4);
                    }
                    if ($mult >= 2) {
                        $this->thb('webp', $path, $thWidth * 2, $thHeight * 2);
                    }
                    $arr['format'] = 'webp,'. $arr['format'];

                }
                $arr['thWidth'] = $thWidth;
                $arr['thHeight'] = $thHeight;
                $arr['thumb'] = $mult;

                // полный формат
                $width = 1178;
                $mult = $this->sizeCheck($pathExt, $width);
                $this->thb($format, $path, $pathExt, $width);
                if ($mult >= 4) {
                    $this->thb($format, $path, $pathExt, $width * 4, $this->findHeight * 4);
                    $mult = 4;
                }
                if ($mult >= 2) {
                    $this->thb($format, $path, $pathExt, $width * 2, $this->findHeight * 2);
                    $mult = $mult === 4 ? 4 : 2;
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
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}/{$month}/{$rand}-{$this->path->baseName}.jpeg", ['jpeg_quality' => 75]);
                // Imags::thumbnail($path, 100, 100)
                // ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/{$modPath}/{$year}/{$month}/{$rand}-{$this->path->baseName}-.jpg", ['quality' => 80]);

                // Image::resize($path, 300, 100)
                //     ->save("{$_SERVER['DOCUMENT_ROOT']}/frontend/web/images/post/{$year}/{$month}/{$rand}-{$this->path->baseName}.jpeg", ['jpeg_quality' => 75]);

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

    private function rsz($format, $path, $pathExt, $width, $height = 0)
    {
        $quality = ['jpeg_quality' => 90];
        Imags::resize("{$path}.{$this->path->extension}", $width, $height)
                ->save("{$path}-{$width}x{$height}.{$format}", $quality);
    }

    private function thb($format, $path, $pathExt, $width, $height = 0)
    {

        if (isset($this->path->extension)) {
            $ext = $this->path->extension;
        } else {
            $ext = 'jpeg';
        }

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
            Imags::thumbnail($pathExt, $width, $height)
                ->save("{$path}-{$width}x{$height}.{$format}", $quality);
        } else {
            Imags::thumbnail($pathExt, $width, $this->findHeight)
                ->save("{$path}-{$width}x{$this->findHeight}.{$format}", $quality);
        }
    }
}
