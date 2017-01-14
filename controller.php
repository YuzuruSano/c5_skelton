<?php
namespace Concrete\Package\SuitonBaseUtil;
defined('C5_EXECUTE') or die("Access Denied.");

use Package;
use Concrete\Package\SuitonBaseUtil\Src\AdditionalUtil\AdditionalUtilServiceProvider;
use Core;
use Config;
use Concrete\Core\Page\Theme\Theme;
use Environment;

class Controller extends Package
{
	protected $pkgDescription = "Base utilies and snipetts";
	protected $pkgName = "Suiton Base Util";
	protected $pkgHandle = 'suiton_base_util';
	protected $appVersionRequired = '5.7.3.1';
	protected $pkgVersion = '1.1.0';

	 public function on_start()
	{
		/* ===============================================
		register assets
		=============================================== */
		$al = \Concrete\Core\Asset\AssetList::getInstance();
		/* css
		----------------------- */
		$css = array(
			'example-css' => $this->pkgThemePath . 'example.css',
		);
		foreach($css as $h => $n){
			$al->register('css',$h,$n,array(),$this->pkgHandle);
		}
		/* external css
		----------------------- */
		// $css_ext = array(
		// 	'Roboto-css' => 'https://fonts.googleapis.com/css?family=Roboto'
		// );
		// foreach($css_ext as $h => $n){
		// 	$al->register('css',$h,$n,array('local' => false),$this->pkgHandle);
		// }
		/* js
		----------------------- */
		$js = array(
			'sample-js' => $this->pkgThemePath . 'samplen.js'
		);
		foreach($js as $h => $n){
			$al->register(
				'javascript',$h,$n,
				array(
					'version'  => '1.0.0',
					'position' => \Concrete\Core\Asset\Asset::ASSET_POSITION_FOOTER,
					'minify' => false,
					'combine' => true
				),
				$this->pkgHandle
			);
		}
		/* external JS
		----------------------- */
		// $js_ext = array(
		// 	'maps.api' => 'http://maps.google.com/maps/api/js?sensor=true'
		// );
		// foreach($js_ext as $h => $n){
		// 	$al->register(
		// 		'javascript',$h,$n,
		// 		array(
		// 			'version'  => '1.0.0',
		// 			'position' => \Concrete\Core\Asset\Asset::ASSET_POSITION_FOOTER,
		// 			'minify' => false,
		// 			'combine' => true,
		// 			'local' => false
		// 		),
		// 		$this->pkgHandle
		// 	);
		// }
		/* ===============================================
		Save my config
		=============================================== */
		$config_param = array(
			'seo.title_format' => '%2$s | %1$s',
			'external.news_overlay' => false,
		);
		$this->setMyConfig($config_param);
		/* ===============================================
		Reading the general-purpose functional class as a helper
			Thanks!! http://www.concrete5.org/community/forums/5-7-discussion/helpers/

		If you want to add functions ,
		add functions to 'this_package/src/AdditionalUtil/Service/AdditionalUtil.php'
		=============================================== */
		$app = Core::getFacadeApplication();
		$sp = new AdditionalUtilServiceProvider($app);
		$sp->register();
		/* ===============================================
		sitemap extend
		未承認バージョンの有無・権限オーバーライド状況の表示
		=============================================== */
		Core::bind('helper/concrete/dashboard/sitemap', 'Concrete\Package\SuitonBaseUtil\Src\Application\Service\Dashboard\ExtendSitemap');
		/* ===============================================
		override core components
		=============================================== */
		$env = Environment::get();
		$env->overrideCoreByPackage('elements/header_required.php', $this);
	}

	public function install(){
		// Run default install process
		$pkg = parent::install();

		//theme install
		Theme::add('base_theme', $pkg);
	}

	/**
	* Set congfig
	* Thanks! https://gist.github.com/hissy/d11551ad58e5f3d0fcd4
	*/
	private function setMyConfig($param = null){
		if($param){
			foreach($param as $key => $val)
			Config::set('concrete.'.$key, $val);
		}
	}
}
