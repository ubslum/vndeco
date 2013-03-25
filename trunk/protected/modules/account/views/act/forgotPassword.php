<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Forgot Password');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Forgot Password'),
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'forgot password');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'If you have forgotten your password, you can request to reset it.');
?>

<div class="form">
    <?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'forgot-password-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            )
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
        <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Next'), array('class'=>'glare-button')); ?>
    </div>
    <?php $this->endWidget();?>
</div>