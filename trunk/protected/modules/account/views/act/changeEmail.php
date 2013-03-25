<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Email');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Email')
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'change email');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change your email address');
?>
<?php if(!Yii::app()->user->hasFlash('success') && $model!=null):?>
<div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array('id'=>'change-email-form', 'enableAjaxValidation'=>true, 'enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true))); ?>
    <p class="note"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You have to re-activate your account after changing your email');?></p>

    <div class="row">
            <?php echo $form->labelEx($model, 'newEmail'); ?>
            <?php echo $form->textField($model, 'newEmail', array('size'=>32, 'maxlength'=>128)); ?>
            <?php echo $form->error($model, 'newEmail'); ?>
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
            <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Email'),        array('class'=>'glare-button')); ?>
    </div>

        <?php $this->endWidget(); ?>
</div>
<?php endif;?>