<?php

require_once(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . '3rdparty' . DIRECTORY_SEPARATOR . 'facebook' . DIRECTORY_SEPARATOR . 'facebook.php');

class FacebookApi extends Facebook {

    public function __construct() {
        $config = array(
            'appId' => Yii::app()->params['facebook']['fbAppId'],
            'secret' => Yii::app()->params['facebook']['fbSecret'],
            'cookie' => true,
        );

        $this->setAppId($config['appId']);
        $this->setApiSecret($config['secret']);
        if (isset($config['cookie'])) {
            $this->setCookieSupport($config['cookie']);
        }
        if (isset($config['domain'])) {
            $this->setBaseDomain($config['domain']);
        }
        if (isset($config['fileUpload'])) {
            $this->setFileUploadSupport($config['fileUpload']);
        }
    }

}