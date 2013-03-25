<?php
/* @var $this SliderImageController */
/* @var $model SliderImage */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'slider-image-form',
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	//'enableAjaxValidation'=>false,
        //'enableClientValidation'=>true,
        //'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>

	<p class="note"><?php echo Yii::t(Common::generateMessageCategory(null, 'CoreMessage'), 'Fields with');?> <span class="required">*</span> <?php echo Yii::t(Common::generateMessageCategory(null, 'CoreMessage'), 'are required.');?></p>

	<?php echo $form->errorSummary($model); ?>
        
        <?php if(!$model->isNewRecord):?>
        <div class="row">
            <?php echo CHtml::image(Yii::app()->request->baseUrl . '/image.php?type=sliderThumb&size=big&id=' . $model->id, 'Image');?>
        </div>
        <div><hr /></div>
        <?php endif;?>
        
	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>        

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alt'); ?>
		<?php echo $form->textField($model,'alt',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'alt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_transition'); ?>
		<?php echo $form->dropDownList($model,'data_transition', SliderImage::getDataTransitionList(), array('prompt'=>'----------')); ?>
		<?php echo $form->error($model,'data_transition'); ?>
	</div>





	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t(Common::generateMessageCategory(null,'CoreMessage'), 'Create') : Yii::t(Common::generateMessageCategory(null,'CoreMessage'), 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->