<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 07.05.2016
 * Time: 10:35
 */
 
namespace frontend\components;
use yii\base\Widget;
use common\models\DzhComments;
use Yii;

class CommentsWidget extends Widget{

    public $tpl;
    public $param;
    public $tree;
    public $menuHtml;
    public $model;

    public function init(){
        parent::init();
        if( $this->tpl === null ){
            $this->tpl = 'comments';
        }
        $this->tpl .= '.php';
    }

    public function run(){
        // if($this->tpl == 'menu.php') {
        //     $menu = Yii::$app->cache->get('menu');
        //     if($menu) return $menu;
        // }
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        return $this->menuHtml;
    }

    public function getUserinfo()
    {
        return $this->data->userInfo->fio;
    }

    protected function getTree(){
        $tree = []; 
        foreach ($this->model as $id=>&$node) {
            if (!$node['id_parent'])
                $tree[$id] = &$node;
            else
                $this->model[$node['id_parent']]['childs'][$node['id']] = &$node;
        } 
        //dump($tree);
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '') 
    {
        $str = '';
        $i = 1;
        foreach($tree as $subtree) {
            $str .= $this->catToTemplate($subtree, $this->param);
            $i++;
        }
        return $str;
    }

    protected function catToTemplate($subtree, $id) 
    {
        ob_start();
        include __DIR__ . '/widget_tpl/' . $this->tpl;
        return ob_get_clean();
    }


} 