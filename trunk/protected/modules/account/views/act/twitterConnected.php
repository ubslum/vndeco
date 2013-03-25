<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Update Information');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Update Information')
);

$script = <<<EOB
$("#connect-account-button").click(function() {
  $("#new-account-form").fadeOut(150);
  $("#connect-account-form").show(250);  
});
$("#new-account-button").click(function() {
  $("#connect-account-form").fadeOut(150);
  $("#new-account-form").show(250);
});
EOB;
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('twitter-connect', $script, CClientScript::POS_READY);
?>
<?php if (!Common::hasFlashMessages()): ?>
    <div class="flash-notice">
        <h5><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), '{TWITTER_NAME}, you are almost there!', array('{TWITTER_NAME}' => $session['accessToken']['screen_name'])); ?></h5>
        <div><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'As you have logged in via Twitter for the first time, we just need a few more details before we can proceed.'); ?></div>
        <div><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You can either create a new {APP_DOMAIN} account or connect your Twitter account to your existing {APP_DOMAIN} account.', array('{APP_DOMAIN}' => Common::getSetting('appDomainName'))); ?></div>    
    </div>

    <div class="border-box">
        <div align="center">
            <span id="new-account-button" class="glare-button">
                <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'I need to create a NEW {APP_DOMAIN} account', array('{APP_DOMAIN}' => Common::getSetting('appDomainName'))); ?>
            </span>
            &nbsp;&nbsp;
            <span id="connect-account-button" class="fuzzy-button">
                <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'I want to connect an EXISTING {APP_DOMAIN} account', array('{APP_DOMAIN}' => Common::getSetting('appDomainName'))); ?>    
            </span>
        </div>

        <div><br /></div>
        <div style="width: 240px; margin-left: auto; margin-right: auto;">

            <div id="new-account-form" class="form" style="display: <?php echo isset($_POST['TwitterNewAccountForm']) ? 'inline' : 'none'; ?>;">
                <?php $this->widget('WTwitterNewAccount'); ?>
            </div>        
            <div id="connect-account-form" class="form" style="display: <?php echo isset($_POST['TwitterConnectForm']) ? 'inline' : 'none'; ?>;">
                <?php $this->widget('WTwitterConnect'); ?>
            </div>

        </div>
    </div>
<?php endif; ?>