<?php
namespace Concrete\Package\BaseUtility\Theme\BaseTheme;
defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Area\Layout\Preset\Provider\ThemeProviderInterface;
use Concrete\Core\Page\Theme\Theme;

class PageTheme extends Theme implements ThemeProviderInterface
{
	/**
	 * テーマで利用するアセットファイル群の定義
	 */
	public function registerAssets() {
		$this->requireAsset('javascript', 'jquery');
		$this->requireAsset('javascript', 'underscore');
		$this->requireAsset('javascript', 'jquery/ui');
		$this->requireAsset('css', 'jquery/ui');

		/* my css
		package/controllerで定義したアセットハンドルを配列に記述
		----------------------- */
		// $local_css = array(
		// 	'sample-css',
		// );
		// foreach($local_css as $css){
		// 	$this->requireAsset('css', $css);
		// }

		/* my js
		package/controllerで定義したアセットハンドルを配列に記述
		----------------------- */
		// $local_js = array(
		// 	'sample-js'
		// );
		// foreach($local_js as $js){
		// 	$this->requireAsset('javascript', $js);
		// }
	}
	/**
	 * エリアのカスタムクラス設定時にデフォルト登録しておくクラス
	 *
	 * @return array
	 */
	public function getThemeAreaClasses()
	{
		return array(
			// 'Main' => array(
			// 	'mt80'
			// )
		);
	}
	/**
	 * ブロックのカスタムクラス設定時にデフォルト登録しておくクラス
	 *
	 * @return array
	 */
	public function getThemeBlockClasses()
	{
		return array(
			// 'core_area_layout' => array(
			// 	'mt80'
			// )
		);
	}
	/**
	 * エディタのカスタムスタイル設定時にデフォルト登録しておくクラス
	 *
	 * @return array
	 */
	public function getThemeEditorClasses()
	{
		return array(
			// array(
			// 	'title' => t('lead'),
			// 	'menuClass' => '',
			// 	'spanClass' => 'lead',
			// 	'forceBlock' => 1//ブロック要素で囲む
			// ),
			// array(
			// 	'title' => t('text-color-gold'),
			// 	'menuClass' => '',
			// 	'spanClass' => 'color-gold',
			// 	'forceBlock' => -1//spanで囲む
			// )
		);
	}
	/**
	 * カスタムレイアウトプリセット
	 * https://concrete5-japan.org/help/5-7/developer/designing-for-concrete5/adding-complex-custom-layout-presets-in-your-theme/
	 * @return array
	 */
	public function getThemeAreaLayoutPresets()
	{
		$presets = [
			// [
			// 	'handle' => 'sample_layout',
			// 	'name' => 'Sample Layout',
			// 	'container' => '<div class="sample"></div>',
			// 	'columns' => [
			// 		'<div class="sample1"></div>',
			// 		'<div class="sample2"></div>',
			// 	],
			// ]
		];

		return $presets;
	}
}
