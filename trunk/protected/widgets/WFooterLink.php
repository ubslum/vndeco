<?php

/**
 * WFooterLink Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WFooterLink extends CWidget {

    public function run() {
        $this->widget('zii.widgets.CMenu', array(
            'items' =>
            array(
                array('label' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Home'), 'url' => array('/site/index')),
                array('label' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Site Disclaimer'), 'url' => array('/site/page','view'=>'disclaimer')),
                array('label' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Privacy Policy'), 'url' => array('/site/page', 'view'=>'privacyPolicy')),
            ),
        ));
    }

}