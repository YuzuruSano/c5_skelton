<?php
namespace BaseUtility\AdditionalUtil\Service;
defined('C5_EXECUTE') or die("Access Denied.");

use Page;
use Config;

class AdditionalUtil
{
	//サンプル
	public function test($text = 'Hello'){
		return $text;
	}

	/**
	 * $file_objが指定の$thumbnail_type_nameを持つ際にサムネイルURLを返す。
	 * サムネイルタイプが存在しない場合はフルサイズ画像を返す
	 *
	 * @param object $file_obj
	 * @param str $thumbnail_type_name
	 * @return str file url
	 */
	public function thumb_src($file_obj,$thumbnail_type_name = 'full'){
		$file_src = "";
		if($file_obj) {
			$handles = array();
			foreach($file_obj->getThumbnails() as $ff){
				$handles[] = $ff->getThumbnailTypeVersionObject()->getHandle();
			}

			if(in_array($thumbnail_type_name, $handles)){
				$type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle($thumbnail_type_name);
				$file_src = $file_obj->getThumbnailURL($type->getBaseVersion());
				return $file_src;
			}else{
				$path = $file_obj->getRelativePath();
				if(!$path) {
					$path = $file_obj->getURL();
				}
				return $path;
			}
		}

		return false;
	}
	/**
	 * 2つの日付の差分を返す
	 *
	 * @param $date1 $file_obj
	 * @param $date2 $thumbnail_type_name
	 * @return str num
	 */
	function day_diff($date1, $date2) {
		// 日付をUNIXタイムスタンプに変換
		$timestamp1 = strtotime($date1);
		$timestamp2 = strtotime($date2);

		// 何秒離れているかを計算
		$seconddiff = abs($timestamp2 - $timestamp1);

		// 日数に変換
		$daydiff = $seconddiff / (60 * 60 * 24);

		// 戻り値
		return $daydiff;
	}

	/**
	* 現在の言語セクション情報を返す。
	*
	* @param $page $pageobj
	* return array
	* 	$languages 設定されている言語セクションのID=>名称 配列
	* 	$activeLanguage 現在の言語セクション
	* 	$defaultLocale デフォルト言語が設定されていればその情報
	* 	$locale 現状のセクションスラッグ
	 */
	public function get_lange_data($page){
		if(!is_object($page)) return false;

		$data = array();
		$ml = Section::getList();
		$al = Section::getBySectionOfSite($page);
		$languages = array();
		$locale = \Localization::activeLocale();
		if (is_object($al)) {
		    $locale = $al->getLanguage();
		}
		foreach ($ml as $m) {
		    $languages[$m->getCollectionID()] = $m->getLanguageText($locale);
		}
		$languageSections = $ml;
		if (is_object($al)) {
			$activeLanguage = $al->getCollectionID();
		}
		$dl = \Core::make('multilingual/detector');
		$defaultLocale =  $dl->getPreferredSection();
		$data['languages'] = $languages;
		$data['activeLanguage'] = $activeLanguage;
		$data['defaultLocale'] = $defaultLocale;
		$data['locale'] = $locale;

		return $data;
	}

	/**
	* 現在のページに関連する多言語ページがあった場合、そのIDを配列で返す。
	*
	* @param $languages 言語セクションの配列
	* @param $active 現在の言語セクションID
	* @param $page 対象のページオブジェクト
	* return array 対象のページID
	 */
	public function get_relate_url($languages,$active,$page){
		if(empty($languages)) return false;

		unset($languages[$active]);
		$relatedIDs = array();
		foreach($languages as $lkey => $lval){
			$lang = Section::getByID($lkey);
			$tpage = $lang->getTranslatedPageID($page);
			if($tpage){
				$relatedIDs[] = $lang->getTranslatedPageID($page);
			}
		}

		if(empty($relatedIDs)){
			return false;
		}

		return $relatedIDs;
	}
}
