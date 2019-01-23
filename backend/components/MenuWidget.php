<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 07.05.2016
 * Time: 10:35
 */

namespace backend\components;
use yii\base\Widget;
//use common\models\DjCategory;
use Yii;

class MenuWidget extends Widget{

    public $tpl;
    public $data;
    public $tree;
    public $menuHtml;
    public $model;

    public function init(){
        parent::init();
        if( $this->tpl === null ){
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    public function run(){
        // if($this->tpl == 'menu.php') {
        //     $menu = Yii::$app->cache->get('menu');
        //     if($menu) return $menu;
        // }

        //$this->data = DjCategory::find()->indexBy('id')->orderBy('name')->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        if($this->tpl == 'menu.php') {
            //Добавляем в кеш
            //Yii::$app->cache->set('menu', $this->menuHtml, 60 );
        }
        return $this->menuHtml;
    }

    protected function getTree(){
        $tree = [];
        foreach ($this->data as $id=>&$node) {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '') 
    {
        $str = '';
        $i = 1;
        foreach($tree as $category) {
            $str .= $this->catToTemplate($category, $tab);
            $i++;
        }
        return $str;
    }

    protected function catToTemplate($category, $tab) 
    {
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }


} 