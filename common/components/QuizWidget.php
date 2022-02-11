<?php

namespace common\components;

use Yii;
use yii\base\Widget;
use backend\models\Quiz;
use backend\models\Answer;

class QuizWidget extends Widget
{
    public $id;
    public $model;
    public $data;
    public $tree;
    public $menuHtml;
    
    public function init()
    {
        parent::init();

    }

    public function run()
    {

        $this->data = Quiz::find()
                ->with('answers')
                ->where(['survey_id' => $this->id])
                ->indexBy('id')
                ->asArray()
                ->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        // var_dump('<pre>');
        // var_dump($this->data);
        // var_dump('</pre>');
        // die;
        // echo '<pre>' . print_r($this->data, true) . '</pre>';
        // die;
        
        return $this->menuHtml;

        return $this->data;
    }

    protected function getTree()
    {
        $tree = [];
        foreach($this->data as $id => &$node){

            if(!$node['parent_id']){
                $tree[$id] = &$node;
            }else{
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
            }
        }

        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach($tree as $quiz){
            $str .= $this->catToTemplate($quiz, $tab);
        }
        return $str;
    }

    protected function catToTemplate($quiz, $tab)
    {
        ob_start();
        include __DIR__ . '/quiz/quiz.php';
        return ob_get_clean();
    }
}