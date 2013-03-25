<?php

/**
 * WAfterContent Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WAfterContent extends CWidget {

    public $params = array();

    public function run() {
        $a = array(
//            '*'=>array(
//                array('name' => 'WSocialButton', 'params' => array('style'=>'box', 'align'=>'center')),
//            ),
        );
        if (isset($a[Common::getMCA()]))
            foreach ($a[Common::getMCA()] as $w) {
                echo '<div class="widget">';
                $this->widget($w['name'], $w['params']);
                echo '</div>';
            }
            
        if (isset($a['*']))
            foreach ($a['*'] as $w) {
                echo '<div class="widget">';
                $this->widget($w['name'], $w['params']);
                echo '</div>';
            }            
    }

}