<?php
namespace Concrete\Package\SuitonBaseUtil\Controller\Dialog\File;
defined('C5_EXECUTE') or die("Access Denied.");

use \Concrete\Controller\Backend\UserInterface as BackendInterfaceController;
use FilePermissions;
use Loader;
use \Concrete\Controller\Search\Files as SearchFilesController;

class Search extends BackendInterfaceController
{

    protected $viewPath = '/dialogs/file/search';

    protected function canAccess()
    {
        $cp = FilePermissions::getGlobal();
        if ($cp->canSearchFiles() || $cp->canAddFile()) {
            return true;
        } else {
            return false;
        }
    }

    public function view()
    {
        $cnt = new SearchFilesController();
        $cnt->search();
        $result = Loader::helper('json')->encode($cnt->getSearchResultObject()->getJSONObject());
        $this->requireAsset('select2');
        $this->set('result', $result);
        $this->set('searchController', $cnt);
    }

}