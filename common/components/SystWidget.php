<?php

namespace common\components;

use Yii;
use yii\base\Widget;
use backend\models\SysItm;
use backend\models\Answer;

class SystWidget extends Widget
{
    public $id;
    public $model;
    public $data;
    public $tree;
    public $menuHtml;
    public $tpl;
    
    public function init()
    {
        parent::init();
        if($this->tpl === null){
            $this->tpl = 'syst';
        }
        $this->tpl .= '.php';

    }

    public function run()
    {

        $this->data = SysItm::find()
                ->where(['syst_id' => $this->id])
                ->indexBy('id')
                ->asArray()
                ->all();

        $this->tree = $this->getTree();

        $this->menuHtml = $this->getMenuHtml($this->tree);

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
        foreach($tree as $syst){
            $str .= $this->catToTemplate($syst, $tab);
        }
        return $str;
    }

    protected function catToTemplate($syst, $tab)
    {
        ob_start();
        include __DIR__ . '/syst/' . $this->tpl;;
        return ob_get_clean();
    }
}