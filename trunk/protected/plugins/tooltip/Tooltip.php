<?php

/**
 * Tooltip Class
 * @author Gia Duy (admin@giaduy.info)
 */
class Tooltip extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        parent::run();
        $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', false, -1, YII_DEBUG);
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($assets . '/tools.tooltip-1.1.3.min.js');
        $cs->registerCssFile($assets . '/default.css');
        $cs->registerScript('tooltip', '$(".icon-tooltip").tooltip({position: "top center"});', CClientScript::POS_READY);
        
    }

}