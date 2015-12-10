<?php
namespace Concrete\Package\SuitonBaseUtil\Controller\SinglePage\Dashboard\System\Basics;
defined('C5_EXECUTE') or die("Access Denied.");

use \Concrete\Core\Page\Controller\DashboardPageController;
use Config;
use Loader;

class Name extends DashboardPageController {

	public function view() {
		$this->set('site', h(Config::get('concrete.site')));
		$this->set('mdesc', h(Config::get('concrete.mdesc')));
		$this->set('mkeyword', h(Config::get('concrete.mkeyword')));
	}

	public function sitename_saved() {
		$this->set('message', t("Your site's name has been saved."));
		$this->view();
	}

	public function update_sitename() {
		if ($this->token->validate("update_sitename")) {
			if ($this->isPost()) {
				Config::save('concrete.site', $this->post('SITE'));
				Config::save('concrete.mdesc', $this->post('MDESC'));
				Config::save('concrete.mkeyword', $this->post('MKEYWORD'));
				$this->redirect('/dashboard/system/basics/name','sitename_saved');
			}
		} else {
			$this->set('error', array($this->token->getErrorMessage()));
		}
	}


}