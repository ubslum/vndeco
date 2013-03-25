<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Password');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Password'),
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change password');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change your current password');
?>
<?php if(!Common::hasFlashMessages()):?>
<div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
                            'id'=>'acc-form',
                            'enableAjaxValidation'=>true,
                            'enableClientValidation'=>true
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
            <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Password'), array('class'=>'button')); ?>
    </div>

        <?php $this->endWidget(); ?>
</div>
<?php endif;?>