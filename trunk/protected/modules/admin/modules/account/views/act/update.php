<?php
$this->pageTitle='Admin Control Panel - Edit Account';
$this->breadcrumbs=array(
        'ACP Home',
	'Account Management',
        $model->username,
	'Edit Account',
);
?>

<h1>Update Account <?php echo $model->username; ?></h1>

<div class="form">

<?php echo CHtml::beginForm(); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo CHtml::errorSummary($model); ?>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo CHtml::error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'email'); ?>
		<?php echo CHtml::activeTextField($model,'email',array('size'=>50,'maxlength'=>50, 'disabled'=>'disabled')); ?>
		<?php echo CHtml::error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'status'); ?>
		<?php echo CHtml::activeDropDownList($model, 'status', array(0=>'Unactive', 1=>'Active')); ?>
		<?php echo CHtml::error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button')); ?>
	</div>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->