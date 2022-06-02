<?php
namespace common\components;

// use common\models\Sef;
use yii\web\UrlRuleInterface;
use frontend\models\Post;
use backend\models\Category;
// use yii\base\Object as Obj;

class PageRule implements UrlRuleInterface {

    // public $connectionID = 'db';
    // public $name;

    // public function init(){
    //     if ($this->name === null) {
    //         $this->name = __CLASS__;
    //     }
    // }

    public function createUrl($manager, $route, $params)
    {

        if (isset($params['id']) === false) { // проверяем, что это маршрут для страницы и нам передали id-записи
            return false; // return false сообщает UrlManager-у, что мы не смогли построить url и необходимо попробовать применить следующее правило
        }

        if ($route === 'category') {
            $slug = Category::find()
                ->select('url')
                ->where(['id' => $params['id']])
                ->scalar();
            if ($slug !== false) {
                return '/' . $slug;
            }
        }

        $slug = Post::find() // тут все просто. Это поиск записи в БД.
            // ->with('category')
            ->select('url')
            ->where(['id' => $params['id']])
            ->scalar();

        if ($slug !== false) {
            return '/' . $slug;
        }
        return false;

        // $slug = Post::find() // тут все просто. Это поиск записи в БД.
        //     // ->with('category')
        //     ->select(['slug', 'category_id'])
        //     ->where(
        //         [
        //             'id' => $params['id'],
        //         ]
        //     )
        //     ->one();

        // $category_id = $slug->category_id;
        // $slug = $slug->slug;
        // do {
        //     $category = Category::find()
        //                 ->select(['parent_id', 'slug'])
        //                 ->where(['id' => $category_id])
        //                 ->one();

        //     $slug = $category->slug . '/'. $slug;
        //     $category_id = $category->parent_id;

        // } while ($category_id != 0);

        // if ($slug !== false) { // если поиск увенчался успехом, то неободимо вернуть найденный урл
        //     return '/' . $slug; // слеш в начале дает знать, что это абсолютный url
        // }
        // return false; // мы ничего не нашли в БД :(
    }

    public function parseRequest($manager, $request)
    {

        $url = trim($request->pathInfo, '/'); // удаляем слеши из начала и конца

        $category = Category::find()
            ->select(['id', 'url'])
            ->where('binary url=:url')
            ->addParams([':url' => $url])
            ->one();

        if (!empty($category)) {
            return ['/post/index', ['category_id' => $category->id]];
        }
        $post = Post::find()
            ->select(['id', 'url'])
            ->where(['status' => 1])
            ->andWhere('binary url=:url')
            ->addParams([':url' => $url])
            ->one();

        if ($post !== null) {
            return ['post/show', ['id' => $post->id]];
        }
        return false;
    }
}