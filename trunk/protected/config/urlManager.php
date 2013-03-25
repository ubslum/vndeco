<?php
if (!isset($_SERVER['REMOTE_ADDR'])) return array('urlFormat' => 'get'); // Running in Command line

return array(
    'class'=>'MyUrlManager',
    'urlFormat' => 'path',
    'showScriptName' => false,
    'rules' => array(
        'robots.txt'=>'site/robots',
        'sitemap<page:[0-9]+>.xml'=>'site/sitemap',
        'sitemap.xml'=>'site/sitemap',
        
        '<lang:.*?>/home' => 'site/index',               
        '<lang:.*?>/contact.html' => 'site/contact',
        '<lang:.*?>/<view:\w+>.html' => 'site/page',
        '<lang:.*?>/admin/<module:\w+>/<controller:\w+>/<action:\w+>' => 'admin/<module>/<controller>/<action>',
        '<lang:.*?>/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
        '<lang:.*?>/<module:\w+>/<controller:\w+>' => '<module>/<controller>',
        '<lang:.*?>/<module:\w+>' => '<module>',
        '<lang:.*?>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '<lang:.*?>/<controller:\w+>' => '<controller>',        
        
        /* NO LANG */
        /*
        '<lang:.*?>/home' => 'site/index',               
        '<lang:.*?>/contact.html' => 'site/contact',
        '<lang:.*?>/<view:\w+>.html' => 'site/page',
        '<lang:.*?>/admin/<module:\w+>/<controller:\w+>/<action:\w+>' => 'admin/<module>/<controller>/<action>',
        '<lang:.*?>/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
        '<lang:.*?>/<module:\w+>/<controller:\w+>' => '<module>/<controller>',
        '<lang:.*?>/<module:\w+>' => '<module>',
        '<lang:.*?>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '<lang:.*?>/<controller:\w+>' => '<controller>',        
         */
    ),
);