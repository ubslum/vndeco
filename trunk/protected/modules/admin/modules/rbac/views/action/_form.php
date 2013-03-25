<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo CHtml::errorSummary($model); ?>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'name'); ?>
        <?php echo CHtml::activeTextField($model,'name', array('size'=>60)); ?>
        <?php echo CHtml::error($model,'name'); ?>
    </div>
    
    <?php if($update):?>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'type'); ?>
        <?php echo CHtml::activeDropDownList($model,'type',AuthItem::model()->typeOptions, array('disabled'=>'disabled')); ?>
    </div>
    <?php else:?>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'type'); ?>
        <?php echo CHtml::activeDropDownList($model,'type',AuthItem::model()->typeOptions, array('prompt'=>'----------', 'ajax'=>array('type'=>'POST', 'url'=>$this->createUrl('roleSetting'), 'update'=>'#role-setting'))); ?>
    </div>    
    <?php endif;?>
    
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'description'); ?>
        <?php echo CHtml::activeTextArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'bizrule'); ?>
        <?php echo CHtml::activeTextArea($model,'bizrule',array('rows'=>6, 'cols'=>50)); ?>
    </div>
    
    <?php if($update):?>
    <?php $this->widget('WRoleSetting', array('data'=>$model->data));?>    
    <?php else:?>
    <div id="role-setting"></div>    
    <?php endif;?>
    
    <div class="action">
        <?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->

