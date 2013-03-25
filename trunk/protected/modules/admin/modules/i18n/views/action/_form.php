<div class="form">
    <?php echo CHtml::beginForm(); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'id'); ?>
        <?php echo CHtml::activeDropDownList($model, 'id', $this->getLocaleIDs(), $update?array('disabled'=>'disabled'):null); ?>
        <?php echo CHtml::error($model,'id'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'title'); ?>
        <?php echo CHtml::activeTextField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
        <?php echo CHtml::error($model,'title'); ?>
    </div>

    <?php if(!$model->default_lang):?>
    <div class="row">
            <?php echo CHtml::activeLabelEx($model,'default_lang'); ?>
            <?php echo CHtml::activeDropDownList($model,'default_lang',array(0=>'No',1=>'Yes')); ?>
            <?php echo CHtml::error($model,'default_lang'); ?>
    </div>
    <?php endif;?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->