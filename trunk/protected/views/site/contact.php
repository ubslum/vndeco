<?php
$this->pageTitle = Common::translateMessage('{TITLE} - {APP_NAME}', array('{APP_NAME}' => Yii::app()->name, '{TITLE}' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Contact')));
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Contact'),
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'contact, contact us');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Contact us for more infomation');
$this->setRobots('noindex, follow');
?>
<?php if (!Yii::app()->user->hasFlash('success')): ?>
<h1><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Contact Us'); ?></h1>
<p><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.'); ?></p>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array( 
    'id'=>'contact-form', 
    'enableAjaxValidation'=>true, 
    'enableClientValidation'=>true, 
    'clientOptions'=>array('validateOnSubmit'=>true, 'validationUrl'=>Yii::app()->createUrl('site/performAjaxValidation', array('model'=>'ContactForm', 'form'=>'contact-form'))), 
)); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name'); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'subject'); ?>
        <?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model,'subject'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'body'); ?>
        <?php echo $form->textArea($model, 'body', array('rows' => 6, 'cols'=>65, 'style' => 'width: 99%')); ?>
        <?php echo $form->error($model,'body'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'verifyCode'); ?>
        <div class="clearfix"><?php $this->widget('MyCaptcha'); ?></div>
        <?php echo $form->textField($model, 'verifyCode'); ?>
        <?php echo $form->error($model,'verifyCode'); ?>
        
        <div class="hint"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Please enter the letters as they are shown in the image above.'); ?>
            <br/><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Letters are not case-sensitive.'); ?></div>
    </div>

    <div class="row submit clear">
        <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Submit'), array('class' => 'glare-button')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>