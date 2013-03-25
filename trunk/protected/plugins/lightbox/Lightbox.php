<?php

/**
 * Lightbox Class
 * @author Gia Duy (admin@giaduy.info)
 */
class Lightbox extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        parent::run();
        $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', false, -1, YII_DEBUG);
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($assets . '/js/lightbox.js');
        $cs->registerCssFile($assets . '/css/lightbox.css');       
        $script='
            var lbFileLoadingImage="'.$assets.'/images/loading.gif";
            var lbFileCloseImage="'.$assets.'/images/close.png";
            var lbLabelImage="'.Yii::t('Lightbox', 'Image').'";
            var lbLabelOf="'.Yii::t('Lightbox', 'of').'";
            
';
        $cs->registerScript('lightbox', $script, CClientScript::POS_HEAD);
        
    }

}