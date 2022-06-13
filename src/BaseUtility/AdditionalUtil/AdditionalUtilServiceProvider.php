<?php
namespace BaseUtility\AdditionalUtil;
defined('C5_EXECUTE') or die("Access Denied.");

use \Concrete\Core\Foundation\Service\Provider as ServiceProvider;

class AdditionalUtilServiceProvider extends ServiceProvider {

    public function register() {
        $singletons = array(
            'helper/aUtil' => '\BaseUtility\AdditionalUtil\Service\AdditionalUtil'
        );

        foreach($singletons as $key => $value) {
            $this->app->singleton($key, $value);
        }
    }
}
