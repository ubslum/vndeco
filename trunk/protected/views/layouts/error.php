<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->language; ?>" lang="<?php echo Yii::app()->language; ?>">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="<?php echo Yii::app()->language; ?>" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" />
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div class="container" id="page">
            <div id="header">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
            </div>
            <div class="container">
                <div class="span-24 last">
                    <div id="content">
                        <?php if (Yii::app()->user->hasFlash('success')): ?>
                            <div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
                        <?php endif; ?>
                        <?php if (Yii::app()->user->hasFlash('notice')): ?>
                            <div class="flash-notice"><?php echo Yii::app()->user->getFlash('notice'); ?></div>
                        <?php endif; ?>
                        <?php if (Yii::app()->user->hasFlash('error')): ?>
                            <div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
                        <?php endif; ?>

                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
