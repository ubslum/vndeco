<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-send Activate Email');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-send Activate Email'),
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'activate email');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'If you have not yet received the activation link, please enter your registered e-mail address here so that we can resend you the activation link.');
?>

<?php if (!Yii::app()->user->hasFlash('success')):?>
<div class="form">
    <?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'resend-activate-email-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array('validateOnSubmit'=>true)
    )); 
    ?>
    <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email'); ?>
            <?php echo $form->error($model, 'email'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'verifyCode'); ?>
        <div class="clearfix"><?php $this->widget('MyCaptcha'); ?></div>
        <?php echo $form->textField($model, 'verifyCode'); ?>
        <?php echo $form->error($model, 'verifyCode'); ?>
        <div class="hint">
            <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Please enter the letters as they are shown in the image above.');?><br/>
            <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Letters are not case-sensitive.');?>
        </div>
    </div>
    <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-send activate email'), array('class'=>'glare-button')); ?>
    </div>
        <?php $this->endWidget();?>
</div>
<?php endif;?>