<?php
namespace Concrete\Package\SuitonBaseUtil\Src\Editor;
use Concrete\Core\Http\Request;
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\Legacy\FilePermissions;
use Concrete\Core\Legacy\TaskPermission;
use Concrete\Core\Utility\Service\Identifier;
use Core;

class RedactorEditor extends \Concrete\Core\Editor\RedactorEditor
{
	protected function getEditor($key, $content = null, $options = array())
	{
		// Stop converting divs to paragraphs
		$options['replaceDivs'] = false;
		return parent::getEditor($key, $content, $options);
	}
}