<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="<?php echo Yii::app()->language;?>" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" />
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <?php if($this->canonical!=''):?><link rel="canonical" href="<?php echo $this->canonical;?>" /><?php endif;?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="<?php echo $this->description;?>" />
        <meta name="keywords" content="<?php echo $this->keywords;?>" />
    </head>

    <body>

        <div class="container" id="page">

            <div id="header">
                <div id="logo"><?php echo CHtml::encode(Common::getSetting('appDomainName')); ?></div>
            </div><!-- header -->
            <div class="container">
                <div class="span-24 last">
                    <div id="content">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>

            <div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo Common::getSetting('appDomainName');?>, All Rights Reserved.<br/>
            </div><!-- footer -->

        </div><!-- page -->
    </body>
</html>
