<?php
defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\Multilingual\Page\Section\Section;
$nh = Core::make('helper/navigation');
//view
$v = View::getInstance();
//sitename
$sitename = Config::get('concrete.site');
//lang
$current_section = Section::getCurrentSection();
$current_section_top_id = $current_section->getCollectionID();
$locales = \Site::getSite()->getLocales();
foreach ($locales as $locale) {
	if ($locale->getIsDefault()) {
		$defaultLocaleID = $locale->getSiteLocaleID();
	}
}
//current page
$c = Page::getCurrentPage();
$cID = $c->getCollectionID();
if (is_object($c)) {
	$cp = new Permissions($c);
}

/**
 * Handle page title
 */

if (is_object($c)) {
	// We can set a title 3 ways:
	// 1. It comes through programmatically as $pageTitle. If this is the case then we pass it through, no questions asked
	// 2. It comes from meta title
	// 3. It comes from getCollectionName()
	// In the case of 3, we also pass it through page title format.

	if (!isset($pageTitle) || !$pageTitle) {
		// we aren't getting it dynamically.
		$pageTitle = $c->getCollectionAttributeValue('meta_title');
		if (!$pageTitle) {
			$pageTitle = $c->getCollectionName();
			if($c->isSystemPage()) {
				$pageTitle = t($pageTitle);
			}
			$seo = Core::make('helper/seo');
			if (!$seo->hasCustomTitle()) {
				$seo->addTitleSegmentBefore($pageTitle);
			}

			if($cID == $current_section_top_id){
				if($current_section_top_id != $defaultLocaleID){
					$pageTitle = $c->getCollectionName();
				}else{
					$pageTitle = $sitename;
				}
			}else{
				// $seo->setSiteName($sitename);
				// $seo->setTitleFormat(Config::get('concrete.seo.title_format'));
				// $seo->setTitleSegmentSeparator(Config::get('concrete.seo.title_segment_separator'));
				// $pageTitle = $seo->getTitle();

				$trail = $nh->getTrailToCollection($c);
				$ancestors = array_reverse($trail);
				$ancestors = array_slice($ancestors, 1);

				$titles = array($pageTitle);
				foreach($ancestors as $t){
					$titles[] = $t->getCollectionName();
				}

				if($current_section_top_id != $defaultLocaleID){
					$site_top = $c->getCollectionName();
				}else{
					$site_top = $sitename;
				}

				$titles[] = $site_top;
				$pageTitle = implode(Config::get('concrete.seo.title_segment_separator'), $titles);
			}
		}
	}

	$pageDescription = (!isset($pageDescription) || !$pageDescription) ? $c->getCollectionDescription() : $pageDescription;
	$cID = $c->getCollectionID();
	$isEditMode = ($c->isEditMode()) ? "true" : "false";
	$isArrangeMode = ($c->isArrangeMode()) ? "true" : "false";


	if ($c->hasPageThemeCustomizations()) {
		$styleObject = $c->getCustomStyleObject();
	} else {
		$pt = $c->getCollectionThemeObject();
		if (is_object($pt)) {
			$styleObject = $pt->getThemeCustomStyleObject();
		}
	}

	if (is_object($styleObject)) {
		$scc = $styleObject->getCustomCssRecord();
	}

} else {
	$cID = 1;
}
?>
<meta http-equiv="content-type" content="text/html; charset=<?php echo APP_CHARSET?>" />
<?php
$mdesc = \Site::getSite()->getAttribute('default_site_desc');
$mkeyword =  \Site::getSite()->getAttribute('default_site_keywords');
if($mdesc){
	$akd = $mdesc;
}else{
	$akd = $c->getCollectionAttributeValue('meta_description');
}
if($mkeyword){
	$akk = $mkeyword;
}else{
	$akk = $c->getCollectionAttributeValue('meta_keywords');
}
?>
<title><?php echo htmlspecialchars($pageTitle, ENT_COMPAT, APP_CHARSET)?></title>
<?php if ($akd) { ?>
<meta name="description" content="<?php echo htmlspecialchars($akd, ENT_COMPAT, APP_CHARSET)?>" />
<?php } else { ?>
<meta name="description" content="<?php echo htmlspecialchars($pageDescription, ENT_COMPAT, APP_CHARSET)?>" />
<?php } ?>
<?php if ($akk) { ?>
<meta name="keywords" content="<?php echo htmlspecialchars($akk, ENT_COMPAT, APP_CHARSET)?>" />
<?php }
if($c->getCollectionAttributeValue('exclude_search_index')) { ?>
	<meta name="robots" content="noindex" />
<?php } ?>
<meta property="og:locale" content="<?php echo \Localization::activeLocale();?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_COMPAT, APP_CHARSET)?>" />
<?php if($akd): ?>
<meta property="og:description" content="<?php echo htmlspecialchars($akd, ENT_COMPAT, APP_CHARSET)?>" />
<?php endif; ?>
<meta property="og:url" content="<?php echo $nh->getLinkToCollection($c); ?>" />
<meta property="og:site_name" content="<?php echo htmlspecialchars($site, ENT_COMPAT, APP_CHARSET)?>" />
<meta property="og:image" content="" />
<?php $u = new User(); ?>
<script type="text/javascript">
<?php
	echo("var CCM_DISPATCHER_FILENAME = '" . DIR_REL . '/' . DISPATCHER_FILENAME . "';\r");
	echo("var CCM_CID = ".($cID?$cID:0).";\r");
	if (isset($isEditMode)) {
		echo("var CCM_EDIT_MODE = {$isEditMode};\r");
	}
	if (isset($isEditMode)) {
		echo("var CCM_ARRANGE_MODE = {$isArrangeMode};\r");
	}
?>
var CCM_IMAGE_PATH = "<?php echo ASSETS_URL_IMAGES?>";
var CCM_TOOLS_PATH = "<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>";
var CCM_APPLICATION_URL = "<?php echo \Core::getApplicationURL()?>";
var CCM_REL = "<?php echo \Core::getApplicationRelativePath()?>";
var CCM_THEME_PATH = '<?php echo $v->getThemePath()?>';
var cm_this_pagenation_total = 0;
</script>
<?php if (isset($scc) && is_object($scc)) { ?>
	<style type="text/css">
		<?php print $scc->getValue();?>
	</style>
<?php } ?>
<?php
if (Config::get('concrete.user.profiles_enabled') && $u->isRegistered()) {
	$v->requireAsset('core/account');
	$v->addFooterItem('<script type="text/javascript">$(function() { ccm_enableUserProfileMenu(); });</script>');
}

$favIconFID=intval(Config::get('concrete.misc.favicon_fid'));
$appleIconFID =intval(Config::get('concrete.misc.iphone_home_screen_thumbnail_fid'));
$modernIconFID = intval(Config::get('concrete.misc.modern_tile_thumbnail_fid'));
$modernIconBGColor = strval(Config::get('concrete.misc.modern_tile_thumbnail_bgcolor'));

if($favIconFID) {
	$f = File::getByID($favIconFID);
	if (is_object($f)) {
		?>
		<link rel="shortcut icon" href="<?php echo $f->getRelativePath() ?>" type="image/x-icon"/>
		<link rel="icon" href="<?php echo $f->getRelativePath() ?>" type="image/x-icon"/>
	<?php
	}
}

if($appleIconFID) {
	$f = File::getByID($appleIconFID);
	if (is_object($f)) {
		?>
		<link rel="apple-touch-icon" href="<?php echo $f->getRelativePath(); ?>"/>
	<?php
	}
}

if($modernIconFID) {
	$f = File::getByID($modernIconFID);
	if(is_object($f)) {
		?>
		<meta name="msapplication-TileImage" content="<?php echo $f->getRelativePath(); ?>" /><?php
		echo "\n";
		if (strlen($modernIconBGColor)) {
			?>
			<meta name="msapplication-TileColor" content="<?php echo $modernIconBGColor; ?>" /><?php
			echo "\n";
		}
	}
}

if (is_object($cp)) {

	Loader::element('page_controls_header', array('cp' => $cp, 'c' => $c));

	$cih = Loader::helper('concrete/ui');
	if ($cih->showNewsflowOverlay()) {
		$v->addFooterItem('<script type="text/javascript">$(function() { new ConcreteNewsflowDialog().open(); });</script>');
	}

	if (array_get($_COOKIE, 'ccmLoadAddBlockWindow') && $c->isEditMode()) {
		$v->addFooterItem('<script type="text/javascript">$(function() { setTimeout(function() { $("a[data-launch-panel=add-block]").click()}, 100); });</script>', 'CORE');
		setcookie("ccmLoadAddBlockWindow", false, -1, DIR_REL . '/');
	}
}


$v->markHeaderAssetPosition();
$_trackingCodePosition = Config::get('concrete.seo.tracking.code_position');
if (empty($disableTrackingCode) && $_trackingCodePosition === 'top') {
	echo Config::get('concrete.seo.tracking.code');
}
echo $c->getCollectionAttributeValue('header_extra_content');
