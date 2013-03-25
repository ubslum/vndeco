<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo CHtml::errorSummary($model); ?>
    <div class="row">
        <ul>
            <li><?php echo CHtml::encode('Valid time values are the numbers indicated and *.'); ?></li>
            <li><?php echo CHtml::encode('You can specifiy exact times using commas to separate them. eg: 1,2,3 (minutes 1,2 and 3)'); ?></li>
            <li><?php echo CHtml::encode('Note that there are no spaces'); ?></li>
        </ul>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'title'); ?>
        <?php echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo CHtml::error($model,'title'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'description'); ?>
        <?php echo CHtml::activeTextArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo CHtml::error($model,'description'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'task_file'); ?>
        <?php echo CHtml::activeTextField($model,'task_file',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo CHtml::error($model,'task_file'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'month'); ?>
        <?php echo CHtml::activeTextField($model,'month',array('size'=>30,'maxlength'=>30)); ?>
        <?php echo CHtml::error($model,'month'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'month_day'); ?>
        <?php echo CHtml::activeTextField($model,'month_day',array('size'=>30,'maxlength'=>30)); ?>
        <?php echo CHtml::error($model,'month_day'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'hour'); ?>
        <?php echo CHtml::activeTextField($model,'hour',array('size'=>30,'maxlength'=>30)); ?>
        <?php echo CHtml::error($model,'hour'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'minute'); ?>
        <?php echo CHtml::activeTextField($model,'minute',array('size'=>30,'maxlength'=>30)); ?>
        <?php echo CHtml::error($model,'minute'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'run_one'); ?>
        <?php echo CHtml::activeDropDownList($model,'run_one', Scheduler::model()->StatusOptions, array('options'=>array('0'=>array('selected'=>'selected')))); ?>
        <?php echo CHtml::error($model,'run_one'); ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabelEx($model,'enabled'); ?>
        <?php echo CHtml::activeDropDownList($model,'enabled', Scheduler::model()->StatusOptions); ?>
        <?php echo CHtml::error($model,'enabled'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->