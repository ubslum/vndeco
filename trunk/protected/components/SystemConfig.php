<?php

/**
 * System Config
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class SystemConfig {

    /**
     * Init function
     */
    public function init() {
        mb_internal_encoding("UTF-8");
        Yii::app()->name = Common::getSetting('appName'); // Name of this web application
        Yii::app()->language = Lang::model()->find('default_lang=1')->id; // The default Language
        Yii::app()->format->dateFormat = Common::getSetting('dateFormat');
        Yii::app()->format->datetimeFormat = Common::getSetting('datetimeFormat');
        Yii::app()->format->timeFormat = Common::getSetting('timeFormat');
        //Yii::app()->format->dateFormat=Common::getSetting('numberFormat');
        //Yii::app()->cache->flush();

        /* WWW Redirect */
        if (isset($_SERVER['HTTP_HOST'], $_SERVER['REMOTE_ADDR']))
            if (!preg_match('/www\..+/', $_SERVER['HTTP_HOST']) && Yii::app()->params['wwwRedirect'])
                Yii::app()->request->redirect('http://www.' . $_SERVER['HTTP_HOST'] . Yii::app()->request->requestUri);

    }

}