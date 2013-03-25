<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Login');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Login'),
);
?>

<div style="width: 550px; margin-left: auto; margin-right: auto;">
    <div class="border-box">
        <h5><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), '{APP_NAME} Login', array('{APP_NAME}' => Yii::app()->name)); ?></h5>
        <div class="form">
            <?php $form = $this->beginWidget('CActiveForm', array('id' => 'login-form', 'enableAjaxValidation' => false, 'enableClientValidation' => true)); ?>
            <?php echo $form->errorSummary($model); ?>
            <table style=" width: 400px; margin-left: auto; margin-right: auto;">
                <tr>
                    <td width="120"><?php echo $form->labelEx($model, 'email'); ?></td>
                    <td><?php echo $form->textField($model, 'email'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'password'); ?></td>
                    <td><?php echo $form->passwordField($model, 'password'); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="rememberMe">
                        <?php echo $form->checkBox($model, 'rememberMe', array('checked' => 'checked')); ?>
                        <?php echo $form->label($model, 'rememberMe'); ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Login'), array('class' => 'glare-button')); ?> or
                        <?php echo CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Register'), $this->createUrl('create')); ?>
                    </td>
                </tr>                
                <tr>
                    <td></td>
                    <td>
                        <?php echo CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Forgot Password?'), $this->createUrl('forgotPassword')); ?><br />
                        <?php echo CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-send activate email'), $this->createUrl('resendActivateEmail')); ?>
                    </td>
                </tr>                 
            </table>
            <?php $this->endWidget(); ?>
        </div>
    </div>

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
    <?php endif;?>

</div>