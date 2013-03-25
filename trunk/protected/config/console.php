<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'name'=>'My Console Application',
    'basePath'=>dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'sourceLanguage'=>'en', /* DO NOT CHANGE THIS */

    /* Load the modules */
    'modules'=>require(dirname(__FILE__) . '/modules.php'),

    /* preloading 'log' component */
    'preload'=>array('sysConfig', 'sysScheduler', 'log'),
    
    /* autoloading model and component classes */
    'import'=>require(dirname(__FILE__) . '/import.php'),

    /* application components */
    'components'=>array(
        'sysConfig'=>array('class'=>'SystemConfig'),
        'sysScheduler'=>array('class'=>'SystemScheduler'),
        'db'=>require(dirname(__FILE__) . '/db.php'),
    ),

    /* Configure Command Globally */
    'commandMap'=>array(
        'migrate'=>array(
            'class'=>'system.cli.commands.MigrateCommand',
            'migrationTable'=>'wv_migration',
            //'templateFile'=>'application.migrations.template',
        ),

    ),
);