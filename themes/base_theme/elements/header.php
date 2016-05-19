<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
global $u;
?>
<!DOCTYPE html><!-- [if IEMobile 7 ]>  <html lang="ja" class="no-js iem7"><![endif] -->
<!-- [if lt IE 7]><html lang="ja" class="no-js lt-ie9 lt-ie8 lt-ie7 ie6"><![endif] -->
<!-- [if IE 7]><html lang="ja" class="no-js lt-ie9 lt-ie8 ie7"><![endif] -->
<!-- [if IE 8]><html lang="ja" class="no-js lt-ie9 ie8"><![endif] -->

<!-- [if (gte IE 8)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html lang="ja" class="no-js">
<!-- <![endif]-->
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta id="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=5.0,user-scalable=1" name="viewport">
	<?php
	Loader::element('header_required');
	//theme path for Javasrcipt
	?>
	<script>var CCM_THEME_PATH = '<?php echo $this->getThemePath()?>'</script>
	<?php
	//for total pagenation num
	//for ajax pagenation,for infinityscroll etc...
	?>
	<script>var cm_this_pagenation_total = 0;</script>
	<!--
	テーマ内のcss・jsを読み込む ※コメントアウトして使用
	<link rel="stylesheet" href="<?php echo $this->getThemePath()?>/lib/css/bxslider-4/jquery.bxslider.css">
	<script src="<?php echo $this->getThemePath()?>/js/base.js"></script>
	-->
<?php
if($c->isEditMode()){
	//編集モード時に適用したい処理
}

if($u->isLoggedIn()) {
	//ログイン状態で適用したい処理
}
?>
</head>

<body id="top">
<div class="<?php echo $c->getPageWrapperClass();?>">
  <div id="wrap">
	 <?php
	 $au = Core::make('helper/aUtil');
	 echo $au->test();
	 ?>