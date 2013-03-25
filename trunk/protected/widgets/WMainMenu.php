<?php

/**
 * WMainMenu Class
 * @link http://www.greyneuron.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; greyneuron.com
 * @license http://www.greyneuron.com/code/license
 */
class WMainMenu extends CWidget {

    //put your code here
    public function run() {
        $menu1 = array(
            array('label' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Home'), 'url' => array('/site/index')),
            array('label' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'About'), 'url' => array('/site/page','view'=>'about')),
        );

        $menu3 = array(
            array('label' => 'Câu Hỏi Thường Gặp', 'url' => array('/faq/index')),
            array('label' => 'Diễn Đàn', 'url' => array('/site/forums'), 'visible'=>true),
            array('label' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Contact'), 'url' => array('/site/contact'), 'visible'=>false),
        );

        $this->widget('zii.widgets.CMenu', array(
            'id'=>'topmenu',
            'items' => array_merge($menu1, CmsCategory::getMenuCategory(), $menu3)
        ));
    }

}