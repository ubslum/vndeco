<?php 
$this->pageTitle='Admin Control Panel - Poll';
$this->breadcrumbs=array(
        'ACP Home',
        'Poll',
        'Add Question',
);
?>

<h1>Add question to Poll</h1>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'poll-add-question-form',
                'enableAjaxValidation' => false,
                'enableClientValidation'=>true,
            )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'question'); ?>
        <?php echo $form->textArea($model, 'question', array('rows' => 5, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'question'); ?>
    </div>

    <div class="row">
        <?php echo $form->checkBox($model, 'multiple'); ?>
        <?php echo $form->labelEx($model, 'multiple'); ?>
        <?php echo $form->error($model, 'multiple'); ?>
    </div>
    <hr />

    <div class="row">
        <?php echo $form->labelEx($model, 'choice0'); ?>
        <?php echo $form->textField($model,'choice0',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice0'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'choice1'); ?>
        <?php echo $form->textField($model,'choice1',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice1'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'choice2'); ?>
        <?php echo $form->textField($model,'choice2',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice2'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'choice3'); ?>
        <?php echo $form->textField($model,'choice3',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice3'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'choice4'); ?>
        <?php echo $form->textField($model,'choice4',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice4'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'choice5'); ?>
        <?php echo $form->textField($model,'choice5',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice5'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'choice6'); ?>
        <?php echo $form->textField($model,'choice6',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice6'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'choice7'); ?>
        <?php echo $form->textField($model,'choice7',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice7'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'choice8'); ?>
        <?php echo $form->textField($model,'choice8',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice8'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'choice9'); ?>
        <?php echo $form->textField($model,'choice9',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model, 'choice9'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Add'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->