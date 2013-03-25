<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Set Username');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Set Username')
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'set username');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Set your username');
?>
<?php if (!Yii::app()->user->hasFlash('success')): ?>
    <?php if(isset($model)):?>
    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array('id' => 'set-username-form', 'enableAjaxValidation' => true, 'enableClientValidation' => true, 'clientOptions' => array('validateOnSubmit' => true))); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('size' => 32, 'maxlength' => 32)); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>


        <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Set Username'), array('class' => 'glare-button')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
    <?php endif; ?>
<?php endif; ?>