<?php

/**
 * WAfterBreadcrumbs Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WAfterBreadcrumbs extends CWidget {

    public $params = array();

    public function run() {
        $a = array(
            '*'=>array(
                array('name' => 'WAddThis', 'params' => array('style'=>'addthis_16x16_style')),
            ),
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