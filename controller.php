<?php
namespace Concrete\Package\BaseUtility;
defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Package\Package;
use \BaseUtility\AdditionalUtil\AdditionalUtilServiceProvider;
use Concrete\Core\Support\Facade\Config;
use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\Foundation\Environment;

class Controller extends Package
{
	protected $pkgDescription = "Base utilies and snipetts";
	protected $pkgName = "Base Utility";
	protected $pkgHandle = 'base_utility';
	protected $appVersionRequired = '8.0.0';
	protected $pkgVersion = '1.1.1';
	protected $pkgAutoloaderRegistries = array(
        'src/BaseUtility/AdditionalUtil' => 'BaseUtility\AdditionalUtil',
        'src/BaseUtility/Application' => 'BaseUtility\Application',
    );

	 public function on_start()
	{
		/* ===============================================
		register assets
		=============================================== */
		$al = \Concrete\Core\Asset\AssetList::getInstance();
		/* css
		----------------------- */
		$css = array(
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
			'seo.title_segment_separator' => ' | ',
			'external.news_overlay' => false,
		);
		$this->setMyConfig($config_param);
		/* ===============================================
		Reading the general-purpose functional class as a helper
			Thanks!! http://www.concrete5.org/community/forums/5-7-discussion/helpers/

		If you want to add functions ,
		add functions to 'this_package/src/AdditionalUtil/Service/AdditionalUtil.php'
		=============================================== */
		$sp = new AdditionalUtilServiceProvider($this->app);
		$sp->register();
		/* ===============================================
		sitemap extend
		未承認バージョンの有無・権限オーバーライド状況の表示
		=============================================== */
		$this->app->bind('helper/concrete/dashboard/sitemap', 'BaseUtility\Application\Service\Dashboard\ExtendSitemap');
		/* ===============================================
		override core components
		=============================================== */
		// $env = Environment::get();
		// $env->overrideCoreByPackage('elements/header_required.php', $this);
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
