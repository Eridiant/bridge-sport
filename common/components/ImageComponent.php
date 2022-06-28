<?php

namespace common\components;

// use Yii;
use yii\web\Controller;
use yii\base\Component;

class ImageComponent extends Component {

    public function image($model, $shablon = 0)
    {

        if (!$shablon) {
            // var_dump('<pre>');
            // var_dump($model);
            // var_dump('</pre>');
            // die;
            $image = $model->image;
            $img = [];
            $source = "";
            $formats = explode(",", $model->format);
            foreach ($formats as $format) {
                do {
                    $img[] = "/images/{$model->path}-" . $model->width * $image . "x" . $model->height * $image . ".{$format} {$image}x";
                    $image = $image / 2;
                } while ($image >= 1);

                switch ($format) {
                    case 'png':
                        $source .= "<source type='image/png' srcset='";
                        break;
                    case 'webp':
                        $source .= "<source type='image/webp' srcset='";
                        break;
                    default:
                        $source .= "<source type='image/jpeg' srcset='";
                        break;
                }
                $image = $model->image;
                $source .= implode(", ", array_reverse($img)) . "'>";
                $img = [];
            }

            $thumb = $model->thumb;
            $img = [];
            $sources = "";
            foreach ($formats as $format) {
                do {
                    $img[] = "/images/{$model->path}-" . $model->thWidth * $thumb . "x" . $model->thHeight * $thumb . ".{$format} {$thumb}x";
                    $thumb = $thumb / 2;
                } while ($thumb >= 1);
                
                switch ($format) {
                    case 'png':
                        $sources .= "<source type='image/png' srcset='";
                        break;
                    case 'webp':
                        $sources .= "<source type='image/webp' srcset='";
                        break;
                    default:
                        $sources .= "<source type='image/jpeg' srcset='";
                        break;
                }
                $thumb = $model->thumb;
                $sources .= implode(", ", array_reverse($img)) . "' media='(max-width: 480px)'" . ">";
                $img = [];
            }
            ob_start();
            include __DIR__ . '/image/index.php';
            return ob_get_clean();
        }
        if ($shablon === "thumb") {
            // var_dump('<pre>');
            // var_dump($model->thumb);
            // var_dump('</pre>');
            // die;
            $thumb = $model->thumb;
            $img = [];
            $sources = "";
            foreach (explode(",", $model->format) as $format) {
                do {
                    $img[] = "/images/{$model->path}-" . $model->thWidth * $thumb . "x" . $model->thHeight * $thumb . ".{$format} {$thumb}x";
                    $thumb = $thumb / 2;
                } while ($thumb >= 1);
                
                switch ($format) {
                    case 'png':
                        $sources .= "<source type='image/png' srcset='";
                        break;
                    case 'webp':
                        $sources .= "<source type='image/webp' srcset='";
                        break;
                    default:
                        $sources .= "<source type='image/jpeg' srcset='";
                        break;
                }
                $thumb = $model->thumb;
                $sources .= implode(", ", array_reverse($img)) . "'>";
                $img = [];
            }

            ob_start();
            include __DIR__ . '/image/thumb.php';
            return ob_get_clean();
        }
        // return include __DIR__ . '/image/index.php';
        // return $this->controller->render('/image/index', compact('model'));
        // $this->render('index', compact('model'));
    }

    // protected function thumb()
    // {
        
    // }
}