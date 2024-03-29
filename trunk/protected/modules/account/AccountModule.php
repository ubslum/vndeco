<?php

class AccountModule extends MyWebModule {

    public $defaultController = 'act';

    public function init() {
        parent::init();

        $this->setImport(array(
                'account.models.*',
                'account.components.*',
                'account.portlets.*',
                'account.widgets.*',

        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}