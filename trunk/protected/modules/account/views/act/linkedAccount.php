<?php
$this->pageTitle = Common::translateMessage('{APP_NAME} - {TITLE}', array('{APP_NAME}' => Yii::app()->name, '{TITLE}' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Linked Accounts')));
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Linked Accounts'),
);
?>
<h6><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You can use one of the accounts below to log into our system.'); ?></h6>

<?php if(Yii::app()->params['twitter']['consumerKey']!='' && Yii::app()->params['twitter']['consumerSecret']!=''):?>
<div class="border-box">
    <center><h3>Twitter</h3></center>
<?php if ($twitter): ?>
    <div>
        <div><b>Twitter Account Connected</b></div>
        <div>Twitter ID: <?php echo $twitter->id_twitter; ?></div>
        <div>Twitter Screen Name: <?php echo $twitter->screen_name; ?></div>
    </div>
    <div><br /></div>
    <div>
        <div><b>Remove Twitter Account</b></div>
        <div>This will remove the account link from Twitter.</div>
        <div><?php echo CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Disassociate Twitter'), Yii::app()->createUrl('account/act/twitterRemove'), array('class' => 'fuzzy-button')); ?></div>
    </div>
<?php else: ?>
    <div class="flash-notice">
        <div><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your {APP_DOMAIN} account is not linked to a Twitter account yet. You will need to connect with Twitter before you can configure your options. Once connected, you can sign in to our system using your Twitter account, and configure synchronization options.', array('{APP_DOMAIN}' => Common::getSetting('appDomainName'))); ?></div>
        <div><br /></div>
        <div><i><b><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Note: if your Twitter account is already connected to another {APP_DOMAIN} account, this will automatic unlink from that account and connect to this account.', array('{APP_DOMAIN}' => Common::getSetting('appDomainName'))); ?></b></i></div>
    </div>
    <center><a href="#" title="Twitter" onclick="window.open('<?php echo Yii::app()->createUrl('account/act/twitterConnect'); ?>','Twitter','width=500,height=450,left='+(screen.width/2-250)+',top=150')"><img class="openid shadow" src="<?php echo Yii::app()->request->baseUrl . '/images/twitter-connect.png'; ?>" alt="Twitter" /></a></center>
<?php endif; ?>
</div>
<?php endif; ?>



<?php if(Yii::app()->params['facebook']['fbAppId']!='' && Yii::app()->params['facebook']['fbAPI']!=''):?>
<div class="border-box">
    <center><h3>Facebook</h3></center>
<?php if ($facebook): ?>
    <div>
        <div><b>Facebook Account Connected</b></div>
        <div>Facebook ID: <?php echo $facebook->id_facebook; ?></div>
        <div>Facebook Screen Name: <?php echo $facebook->name; ?></div>
    </div>
    <div><br /></div>
    <div>
        <div><b>Remove Facebook Account</b></div>
        <div>This will remove the account link from Facebook.</div>
        <div><?php echo CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Remove Facebook'), Yii::app()->createUrl('account/act/facebookRemove'), array('class' => 'fuzzy-button')); ?></div>
    </div>
<?php else: ?>
    <div class="flash-notice">
        <div><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your {APP_DOMAIN} account is not linked to a Facebook account yet. You will need to connect with Facebook before you can configure your options. Once connected, you can sign in to our system using your Facebook account, and configure synchronization options.', array('{APP_DOMAIN}' => Common::getSetting('appDomainName'))); ?></div>
        <div><br /></div>
        <div><i><b><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Note: if your Facebook account is already connected to another {APP_DOMAIN} account, this will automatic unlink from that account and connect to this account.', array('{APP_DOMAIN}' => Common::getSetting('appDomainName'))); ?></b></i></div>
    </div>
    <center><a href="#" title="Facebook" onclick="window.open('<?php echo Yii::app()->createUrl('account/act/facebookConnect'); ?>','Facebook','width=500,height=450,left='+(screen.width/2-250)+',top=150')"><img class="openid shadow" src="<?php echo Yii::app()->request->baseUrl . '/images/facebook-connect.jpg'; ?>" alt="Facebook" /></a></center>
<?php endif; ?>
</div>
<?php endif; ?>