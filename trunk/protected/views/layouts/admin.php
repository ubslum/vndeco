<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <meta name="robots" content="noindex, nofollow" />

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

        <div class="container" id="page" style="width: 98%;">

            <div id="header">
                <div style="float: right; padding: 10px;">Time now: <?php echo date(Common::getSetting('dateTimeFormat'));?></div>
                <div id="logo"><?php echo CHtml::encode('Admin Control Panel'); ?></div>
                
            </div><!-- header -->

            <div id="mainmenu">
                <?php $this->widget('WAdminMenu',array('type'=>'top')); ?>
            </div><!-- mainmenu -->

            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                    'homeLink'=>FALSE,//CHtml::link('ACP', Yii::app()->createUrl('admin')),
                    'links'=>$this->breadcrumbs,
            )); ?><!-- breadcrumbs -->


            <div class="container" style="width: 100%">
                <div class="span-18" style="width: 80%">
                    <div id="content">
                        <?php if(Yii::app()->user->hasFlash('success')):?>
                        <div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
                        <?php endif;?>
                        <?php if(Yii::app()->user->hasFlash('notice')):?>
                        <div class="flash-notice"><?php echo Yii::app()->user->getFlash('notice'); ?></div>
                        <?php endif;?>
                        <?php if(Yii::app()->user->hasFlash('error')):?>
                        <div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
                        <?php endif;?>
                        <div id="ajax-saving" style="display: none;" align="center">Saving</div>
                        <?php echo $content; ?>
                    </div><!-- content -->
                </div>
                <div class="span-6 last" style="width: 18%">
                    <div id="sidebar">
                        <?php
                        $this->widget('WAdminMenu',array('type'=>'sidebar'));
                        ?>
                    </div><!-- sidebar -->
                </div>
            </div>


            <div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo $_SERVER['HTTP_HOST'];?>.<br />
		All Rights Reserved.<br />
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
