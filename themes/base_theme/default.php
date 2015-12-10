<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
$this->inc('elements/header.php');
?>

<?php
	$a = new Area('メインコンテンツ');
	$a->display($c);
?>

<?php $this->inc('elements/footer.php') ?>