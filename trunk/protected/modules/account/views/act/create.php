<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Register');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Register'),
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'register, signup, create account');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'If you are not yet a member, just register a FREE Membership Account.');
?>
<?php if (!Yii::app()->user->hasFlash('success')):?>
    <?php if(!Yii::app()->params['disableExtLogin']):?>
    <div class="border-box" align="center">
        <h5>
            <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Surprise! If you use any of the following services, you can login to our system with just a few clicks.'); ?>
        </h5>
        <a href="#" title="Yahoo" onclick="window.open('<?php echo $this->createUrl('login', array('type' => 'yahoo')); ?>','Facebook','width=500,height=450,left='+(screen.width/2-250)+',top=150')"><img class="openid shadow" src="<?php echo Yii::app()->request->baseUrl . '/images/yahoo.jpg'; ?>" alt="Yahoo" /></a>
        <a href="#" title="Google" onclick="window.open('<?php echo $this->createUrl('login', array('type' => 'google')); ?>','Google','width=500,height=450,left='+(screen.width/2-250)+',top=150')"><img class="openid shadow" src="<?php echo Yii::app()->request->baseUrl . '/images/google.jpg'; ?>" alt="Google" /></a>
        <?php if(Yii::app()->params['facebook']['fbAppId']!='' && Yii::app()->params['facebook']['fbAPI']!=''):?>
        <a href="#" title="Facebook" onclick="window.open('<?php echo $this->createUrl('login', array('type' => 'facebook')); ?>','Facebook','width=500,height=450,left='+(screen.width/2-250)+',top=150')"><img class="openid shadow" src="<?php echo Yii::app()->request->baseUrl . '/images/facebook.jpg'; ?>" alt="Facebook" /></a>
        <?php endif;?>
        <?php if(Yii::app()->params['twitter']['consumerKey']!='' && Yii::app()->params['twitter']['consumerSecret']!=''):?>
        <a href="#" title="Twitter" onclick="window.open('<?php echo $this->createUrl('login', array('type' => 'twitter')); ?>','Twitter','width=500,height=450,left='+(screen.width/2-250)+',top=150')"><img class="openid shadow" src="<?php echo Yii::app()->request->baseUrl . '/images/twitter.jpg'; ?>" alt="Twitter" /></a>
        <?php endif;?>
    </div>
    <hr />
    <?php endif;?>
    <?php if(Yii::app()->params['disableAccountRegistration']):?>
    <div class="flash-notice"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'New account registration temporarily disabled.');?></div>
    <?php else:?>
    <h1><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Register for a new account');?></h1>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    <?php endif;?>
<?php endif;?>