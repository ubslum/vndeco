<?php $form = $this->beginWidget('CActiveForm', array('id' => 'connect-twitter-form', 'enableAjaxValidation' => false, 'enableClientValidation' => true)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <?php echo $form->labelEx($model, 'email'); ?>
    <?php echo $form->textField($model, 'email', array('size' => 32, 'maxlength' => 32)); ?>
</div>
<div class="row">
    <?php echo $form->labelEx($model, 'password'); ?>
    <?php echo $form->passwordField($model, 'password', array('size' => 32, 'maxlength' => 32)); ?>
</div>    
<div class="row buttons">
    <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Connect Account'), array('class' => 'button')); ?>
</div>
<?php $this->endWidget(); ?>    
