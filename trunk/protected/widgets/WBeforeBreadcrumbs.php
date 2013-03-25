<?php

/**
 * WBeforeBreadcrumbs Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WBeforeBreadcrumbs extends CWidget {

    public $params = array();

    public function run() {
        $a = array(
            'CmsAuthorView' => array(
                array('name' => 'WAddThis', 'params' => array('type'=>'share', 'style'=>'addthis_32x32_style')),
                array('name' => 'WAuthorSubscriberBox', 'params' => array()),
                array('name' => 'WAdsense', 'params' => array('params'=>array('size'=>'250x250'))),
            ),
            'SiteIndex'=>array(
                array('name' => 'cms.widgets.WAuthorSpotlight', 'params' => array()),
            ),
        );
    }

}