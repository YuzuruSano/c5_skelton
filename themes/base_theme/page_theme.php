<?php
namespace Concrete\Package\SuitonBaseUtil\Theme\BaseTheme;
defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Page\Theme\Theme;

class PageTheme extends Theme
{
	public function registerAssets() {
		$this->requireAsset('javascript', 'jquery');
		$this->requireAsset('javascript', 'underscore');
		$this->requireAsset('javascript', 'jquery/ui');
		$this->requireAsset('css', 'jquery/ui');
	}
}
