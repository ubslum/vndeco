<?php
$this->pageTitle='Admin Control Panel';
$this->breadcrumbs=array(
    'ACP Home',
);
?>
<p>
    Parameters to be applied to the content (if any): <b><i>{AppName}</i></b>, <b><i>{AppDomainName}</i></b> and <b><i>{AdminEmail}</i></b>
</p>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'static-page-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('style'=>'width: 640px;','maxlength'=>50)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>5, 'style'=>'width: 640px;','maxlength'=>256)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'content'); ?>
        <?php 
             $this->widget('application.plugins.dtinymce.DTinyMce',array(
             'model'=>$model,
             'attribute'=>'content',
             'htmlOptions'=>array('style'=>'width: 640px; height:640px;'),
             'options' => array(
                'entity_encoding'=>'raw',
                'plugins'=>'syntaxhl',
                'theme' => 'advanced',

                'theme_advanced_buttons1' => 'bold,italic,underline,|,justifyfull,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,image,link,unlink,syntaxhl,|,undo,redo,|,removeformat',
                'theme_advanced_buttons2' => '',
                'theme_advanced_buttons3' => '',

                'theme_advanced_toolbar_location'=>'top',
                'theme_advanced_toolbar_align'=>'left',
                'theme_advanced_statusbar_location'=>'bottom',
                'theme_advanced_resizing'=>true,                                 
             ),
             ));
        ?>
        <?php echo $form->error($model,'content'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'keywords'); ?>
        <?php echo $form->textField($model,'keywords',array('style'=>'width: 640px;', 'maxlength'=>256)); ?>
        <?php echo $form->error($model,'keywords'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->