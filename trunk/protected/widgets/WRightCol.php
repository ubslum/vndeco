<?php

/**
 * WRightCol Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WRightCol extends CWidget {

    public $params = array();

    public function run() {
        $a = array(
            'SiteIndex'=>array(
                //array('name' => 'PCategoryMenu', 'params'=>array())
                ),
        );
        
        /* Do not edit */
        if (isset($a['*']))
            foreach ($a['*'] as $w) {
                echo '<div class="widget">';
                $this->widget($w['name'], $w['params']);
                echo '</div>';
            }

        if (isset($a[Common::getMCA()]))
            foreach ($a[Common::getMCA()] as $w) {
                echo '<div class="widget">';
                $this->widget($w['name'], $w['params']);
                echo '</div>';
            }
    }

}