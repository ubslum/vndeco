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
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/commerce.css" />
        <?php if ($this->canonical != ''): ?>
            <link rel="canonical" href="<?php echo $this->canonical; ?>" />
        <?php endif; ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="<?php echo $this->description; ?>" />
        <meta name="keywords" content="<?php echo $this->keywords; ?>" />
        <?php echo $this->openGraphProtocol; ?>
        <?php echo $this->robots; ?>        
    </head>

    <body>
        <div class="container" id="page">
            <div id="header">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
            </div>

            <div id="mainmenu">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' =>
                    array(
                        array('label' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Home'), 'url' => array('/site/index')),
                        array('label' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Contact'), 'url' => array('/site/contact'), 'linkOptions' => array('rel' => 'nofollow')),
                        array('label' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Login'), 'url' => Yii::app()->user->loginUrl, 'linkOptions' => array('rel' => 'nofollow'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'My Account'), 'linkOptions' => array('rel' => 'nofollow'), 'url' => array('/account/act/index'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Logout') . ' (' . Yii::app()->user->name . ')', 'linkOptions' => array('rel' => 'nofollow'), 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                    ),
                ));
                ?>
            </div>

            <div class="content"><?php $this->widget('WBeforeBreadcrumbs'); ?></div>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array('links' => $this->breadcrumbs)); ?><!-- breadcrumbs -->
            <div class="content"><?php $this->widget('WAfterBreadcrumbs'); ?></div>

            <div class="content"><?php $this->widget('WBeforeContent'); ?></div>
            <?php echo $content; ?>
            <div class="content"><?php $this->widget('WAfterContent'); ?></div>

            <div id="footer">                
                <div><?php $this->widget('WFooterLink'); ?></div>
                <div>Copyright &copy; <?php echo date('Y'); ?> by <?php echo Common::getSetting('appDomainName'); ?>, All Rights Reserved.</div>
            </div>
        </div>
    </body>
</html>