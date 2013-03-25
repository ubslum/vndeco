<?php
// change the following paths if necessary
$yii = dirname(__FILE__) . '/../../../framework/yii.php';
//$yii = dirname(__FILE__) . '/../../../Resources/yii/trunk/framework/yii.php';// test
$config = dirname(__FILE__) . '/protected/config/main.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once($yii);
Yii::createWebApplication($config)->run();