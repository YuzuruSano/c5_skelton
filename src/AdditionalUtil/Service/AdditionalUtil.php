<?php
namespace Concrete\Package\SuitonBaseUtil\Src\AdditionalUtil\Service;
defined('C5_EXECUTE') or die("Access Denied.");

use Page;
use Config;

/**
 * @package Helpers
 * @category Concrete
 * @author Yuzuru Sano <sano@suitosha.co.jp>
 * @license    http://www.concrete5.org/license/     MIT License
 */

class AdditionalUtil
{

	public function test(){
		return 'Hello We Are SizenkainoOkite!!';
	}

	public function the_permalink($id = 1,$secureflg = false){
		if(Config::get('concrete.myenv') == 'test'){
			$nom = BASE_URL;
			$secure = DIR_REL;
		}else{
			$nom = 'http://www.designweek-kyoto.com'.DIR_REL;
			$secure = 'https://secure.designweek-kyoto.com'.DIR_REL;
		}

		$p = Page::getByID($id);
		if($secureflg){
			return $secure . $p->getCollectionPath();
		}else{
			return $nom . $p->getCollectionPath();
		}
	}
}
