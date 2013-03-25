<?php $form = $this->beginWidget('CActiveForm', array('id' => 'new-twitter-form', 'enableAjaxValidation' => true, 'enableClientValidation' => true, 'clientOptions'=>array('validateOnSubmit'=>true, 'validationUrl'=>Yii::app()->createUrl('site/performAjaxValidation', array('model'=>'TwitterNewAccountForm', 'form'=>'new-twitter-form'))))); ?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <?php echo $form->labelEx($model, 'username'); ?>
    <?php echo $form->textField($model, 'username', array('size' => 32, 'maxlength' => 32)); ?>
    <?php echo $form->error($model, 'username'); ?>
</div>
<div class="row">
    <?php echo $form->labelEx($model, 'email'); ?>
    <?php echo $form->textField($model, 'email', array('size' => 32, 'maxlength' => 256)); ?>
    <?php echo $form->error($model, 'email'); ?>
</div>    
<div class="row">
    <?php echo $form->labelEx($model, 'emailAgain'); ?>
    <?php echo $form->textField($model, 'emailAgain', array('size' => 32, 'maxlength' => 256)); ?>
    <?php echo $form->error($model, 'emailAgain'); ?>
</div>    
<div class="row buttons">
    <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Create Account'), array('class' => 'button')); ?>
</div>
<?php $this->endWidget(); ?>    
