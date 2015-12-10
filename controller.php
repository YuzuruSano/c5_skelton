<?php
namespace Concrete\Package\SuitonBaseUtil;
defined('C5_EXECUTE') or die("Access Denied.");

use Package;
use Concrete\Package\SuitonBaseUtil\Src\AdditionalUtil\AdditionalUtilServiceProvider;
use BlockType;
use Loader;
use Concrete\Core\Page\Single as SinglePage;
use Core;
use Config;
use User;
use Page;
use UserInfo;
use Exception;
use Concrete\Core\Block\BlockController;
use Route;
use Router;
use Database;
use Concrete\Core\Page\Single;
use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\Foundation\ClassAliasList;

class Controller extends Package
{

    protected $pkgDescription = "Base utilies and snipetts";
    protected $pkgName = "Suiton Base Util";
    protected $pkgHandle = 'suiton_base_util';
    protected $appVersionRequired = '5.7.3.1';
    protected $pkgVersion = '1.0.0';

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
        /*
        Define test or deploy
        Please change host to suit your environment
        ----------------------- */
        if(strstr($_SERVER['SERVER_NAME'],'192.168') || strstr($_SERVER['SERVER_NAME'],'localhost')){
            $env = 'test';
        }else{
            $env = 'deploy';
        }

        if($env == 'test'){
          $normal = BASE_URL;
          $secure = DIR_REL;
        }else{
          $normal = '本番URLをいれる'.DIR_REL;
          $secure = '本番sslURLを入れる'.DIR_REL;
        }

        $config_param = array(
            'seo.title_format' => '%2$s - %1$s',
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

        /* ===============================================
        override system path
        =============================================== */
        /* add file uploader , when call file manager on dialog request
        ----------------------- */
        Route::register('/ccm/system/dialogs/file/search','Concrete\Package\SuitonBaseUtil\Controller\Dialog\File\Search::view');
    }

    public function install(){
        // Run default install process
        $pkg = parent::install();

        //theme install
        Theme::add('base_theme', $pkg);

        $db = Database::getActiveConnection();

        //add and refresh single page
        $this->addSinglePage('/dashboard/system/basics/name', 'Name', 'test');
    }

    public function upgrade()
    {
        $pkg = $this->getByID($this->getPackageID());
        parent::upgrade();
        $db = Database::getActiveConnection();

       $this->addSinglePage('/dashboard/system/basics/name', 'Name', 'test');
    }

    public function uninstall() {
        parent::uninstall();
        $db = Loader::db();
    }

    /**
    * Adds/installs or refresh a single page
    * @param string $pagePath The relative path to the single page
    * @param string $pageName The name of the single page
    * @param string $description The description for the single page
    * Thanks! http://www.code-examples.com/concrete-5-7-creating-a-single-page-for-the-frontend/
    */
    private function addSinglePage($pagePath, $pageName, $description){
       $pkg = Package::getByHandle($this->getPackageHandle());
       $singlePage = Page::getByPath($pagePath);

       if ($singlePage->isError() && $singlePage->getError() == COLLECTION_NOT_FOUND) {
           /* @var $singlePage Single*/
           $singlePage = Single::add($pagePath, $pkg);
           $singlePage->update(array('cName' => $pageName, 'cDescription' => $description));

           return $singlePage;
       }else{//refresh single page by package file
            $cID = Page::getByPath($pagePath)->getCollectionID();
            Loader::db()->execute('update Pages set pkgID = ? where cID = ?', array($pkg->pkgID, $cID));
       }

       return null;
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
