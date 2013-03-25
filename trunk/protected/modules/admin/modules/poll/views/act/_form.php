<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'poll-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'date_begin'); ?>
		<?php echo $form->textField($model,'date_begin',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'date_begin'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'date_end'); ?>
		<?php echo $form->textField($model,'date_end',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'date_end'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'date_show_result'); ?>
		<?php echo $form->textField($model,'date_show_result',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'date_show_result'); ?>
            <div class="hint">Enter 0 to disable showing results</div>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', Poll::getStatusOption()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->