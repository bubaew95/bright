<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 07.05.2016
 * Time: 10:35
 */

namespace backend\components;
use yii\base\Widget;
use Yii;

class ColorBarWidget extends Widget
{	
	public function init(){
        parent::init();
    }
	
	private function curentWeekDay()
	{
		return date("w",  mktime(0,0,0,date("m"),date("d"),date("Y")));
	}

    public function run()
	{
		switch($this->curentWeekDay()) {
			case 0:
				return 'red';
			break;
			case 1:
				return 'green-light';
			break;
			case 2:
				return 'purple-light';
			break;
			case 3:
				return 'yellow-light';
			break;
			case 4:
				return 'blue';
			break;
			case 5:
				return 'green';
			break;
			case 6:
				return 'purple';
			break;
		}
		
	}
	
}