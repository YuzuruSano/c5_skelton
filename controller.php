<?php
namespace Concrete\Package\SuitonBaseUtil;
defined('C5_EXECUTE') or die("Access Denied.");

use Package;
use Concrete\Package\SuitonBaseUtil\Src\AdditionalUtil\AdditionalUtilServiceProvider;
use Core;
use Config;
use Concrete\Core\Page\Theme\Theme;


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
		Sample:register assets
		=============================================== */
		// $al = \Concrete\Core\Asset\AssetList::getInstance();
		// $al->register('css', 'xxx_css', 'css/xxx.css', array(), $this);
		// $al->register('javascript', 'xxx_js', 'js/xxx.js', array(), $this);

		// $al->registerGroup('my_register_group', array(
		//     array('javascript', 'underscore');//sample:Call core JS direct
		//     array('javascript', 'xxx_js'),
		//     array('css', 'xxx_css')
		// ));

		/* ===============================================
		Save my config
		=============================================== */

		$config_param = array(
			'seo.title_format' => '%2$s | %1$s',
			'external.news_overlay' => false,
			'myenv' => $env,
			'normal_url' => $normal,
			'secure_url' => $secure,
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
