<?php
// uncomment the following to define a path alias
Yii::setPathOfAlias('account','application.modules.account');
Yii::setPathOfAlias('plugins','application.plugins');

return array(
    'basePath'=>dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'sourceLanguage'=>'en', /* DO NOT CHANGE THIS */
    //'theme'=>'classic',

    /* Load the modules */
    'modules'=>require(dirname(__FILE__) . '/modules.php'),

    /* preloading 'log' component */
    'preload'=>array('sysConfig', 'sysScheduler', 'log'),

    /* autoloading model and component classes */
    'import'=>require(dirname(__FILE__) . '/import.php'),

    /* application components */
    'components'=>array(
        'sysConfig'=>array('class'=>'SystemConfig'),
        'userCounter'=>array('class'=>'UserCounter'),
        
        //'request'=>array('enableCsrfValidation'=>true, 'csrfTokenName'=>'JSO_CSRF_TOKEN'),

        'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),

        'sysScheduler'=>array(
            'class'=>'SystemScheduler',
        ),

        'cache'=>array('class'=>'system.caching.CFileCache'),

        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CDbLogRoute',
                    'levels'=>'error, warning',
                    'connectionID'=>'db',
                    'autoCreateLogTable'=>false,
                    'logTableName'=>'{{logs}}',
                    'filter'=>array('class' => 'CLogFilter', 'prefixSession' => false,'prefixUser' => false, 'logUser' => true),

                ),
            ),
        ),

        'user'=>array(
            'loginUrl'=>array('/account/act/login'),
            'allowAutoLogin'=>true,
        ),

        'db'=>require(dirname(__FILE__) . '/db.php'),

        'authManager'=>array(
            'class'=>'MyDbAuthManager',
            'connectionID'=>'db',
        ),

        'urlManager'=>require(dirname(__FILE__) . '/urlManager.php'),

        'messages'=>array(
            'class'=>'CPhpMessageSource',
            //'connectionID'=>'db',
            'onMissingTranslation'=>array('MyPhpMessageSource', 'checkMissingTranslation'),

        ),

        /* Access popular AJAX libraries directly from Google's servers.*/
        'clientScript'=>array(
            'scriptMap'=>array(
                'jquery.js'     => 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js',
                'jquery.min.js' => 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js',
                        
                'jquery-ui.js'      => 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js',
                'jquery-ui.min.js'  => 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js',
                
                'jquery.mobile.js'      => 'http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js',
            ),
        ),


    ),

    /* application-level parameters that can be accessed using Yii::app()->params['paramName']*/
    'params'=>require(dirname(__FILE__) . '/params.php'),
);