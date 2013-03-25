<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Answer Secret Question');
$this->breadcrumbs = array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Answer Secret Question')
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'secret question');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Answer secret question');
?>
<?php if (!Common::hasFlashMessages()):?>
<div class="form">
    <?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'secret-question-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array('validateOnSubmit'=>true)
    )); 
    ?>
    <div class="row">
            <?php echo $form->labelEx($model, 'question'); ?>
            <?php echo CHtml::encode($model->user->secret_question); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model, 'answer'); ?>
            <?php echo $form->textField($model, 'answer', array('size'=>50, 'maxlength'=>256)); ?>
            <?php echo $form->error($model, 'answer'); ?>
    </div>
    <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Next'), array('class'=>'glare-button')); ?>
    </div>
        <?php $this->endWidget();?>
</div>
<?php endif;?>