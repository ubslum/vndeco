<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Set Local Password');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Set Password'),
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'set password');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Set your password');
?>

<?php if(!Yii::app()->user->hasFlash('success')):?>
<div class="flash-notice">
    <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You are logged into our system using your Facebook, Twitter, Google or Yahoo account.');?><br />
    <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You can set a local password here. This will allow you to log in directly to our system and browse the site from your mobile device. This is optional and will not change how you currently log in');?>
</div>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
                        'id'=>'set-password-form',
                        'enableAjaxValidation'=>true,
                        'enableClientValidation'=>true,
                        'clientOptions'=>array('validateOnSubmit'=>true)
    )); ?>
    <div class="row">
            <?php echo $form->labelEx($model, 'newPass'); ?>
            <?php echo $form->passwordField($model, 'newPass', array('size'=>32, 'maxlength'=>32)); ?>
            <?php echo $form->error($model, 'newPass'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model, 'newPassAgain'); ?>
            <?php echo $form->passwordField($model, 'newPassAgain', array('size'=>32, 'maxlength'=>32)); ?>
            <?php echo $form->error($model, 'newPassAgain'); ?>
    </div>

    <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Set Password'), array('class'=>'glare-button')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php endif;?>