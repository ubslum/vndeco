<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Password');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Password'),
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'change password');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change your current password');
?>
<?php if(!Yii::app()->user->hasFlash('success')):?>
<div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
                            'id'=>'change-password-form',
                            'enableAjaxValidation'=>true,
                            'enableClientValidation'=>true,
                            'clientOptions'=>array('validateOnSubmit'=>true)
        )); ?>
    <div class="row">
            <?php echo $form->labelEx($model, 'currentPass'); ?>
            <?php echo $form->passwordField($model, 'currentPass', array('size'=>32, 'maxlength'=>32)); ?>
            <?php echo $form->error($model, 'currentPass'); ?>
    </div>
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
            <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Password'), array('class'=>'glare-button')); ?>
    </div>

        <?php $this->endWidget(); ?>
</div>
<?php endif;?>