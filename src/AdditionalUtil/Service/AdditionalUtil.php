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
	//サンプル
	public function test($text = 'Hello We Are SizenkainoOkite!!'){
		return $text;
	}

	/**
	 * ページidを元にドメイン付きのリンクを返す
	 * idが設定されていない場合はトップページのURLを返す
	 * $secureflgをtrueにすることでsslURLを返す
	 *
	 * @param int $id
	 * @param bool $secureflg
	 * @return str url
	 */
	public function the_permalink($id = 1,$secureflg = false){
		if(Config::get('concrete.myenv') == 'test'){
			$nom = BASE_URL;
			$secure = DIR_REL;
		}else{
			$nom = 'deploy_url'.DIR_REL;
			$secure = 'ssl_deploy_url'.DIR_REL;
		}

		$p = Page::getByID($id);
		if($secureflg){
			return $secure . $p->getCollectionPath();
		}else{
			return $nom . $p->getCollectionPath();
		}
	}

	/**
	 * $file_objが指定の$thumbnail_type_nameを持つ際にサムネイルURLを返す。
	 * サムネイルタイプが存在しない場合はフルサイズ画像を返す
	 *
	 * @param object $file_obj
	 * @param str $thumbnail_type_name
	 * @return str file url
	 */
	public function thumb_src($file_obj,$thumbnail_type_name){
		if($file_obj) {
			$handles = array();
			foreach($file_obj->getThumbnails() as $ff){
				$handles[] = $ff->getThumbnailTypeVersionObject()->getHandle();
			}

			if(in_array($thumbnail_type_name, $handles)){
				$file_src = $file_obj->getThumbnailURL($thumbnail_type_name);
			}else{
				$file_src = $file_obj->getThumbnailURL('full');
			}

			return $file_src;
		}
	}
}
