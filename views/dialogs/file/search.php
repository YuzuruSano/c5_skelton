<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<div data-search="files" class="ccm-ui">
<?php Loader::packageElement('files/search','suiton_base_util'); ?>
</div>

<script type="text/javascript">
$(function() {
	$('div[data-search=files]').concreteFileManager({
		result: <?php echo $result?>,
		mode: 'choose'
	});
});
</script>