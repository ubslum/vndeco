<?php
$this->pageTitle='Admin Control Panel - Scheduler';
$this->breadcrumbs=array(
        'ACP Home',
        'Schedulers',
        'View task logs',
);
?>
<h1><?php echo $task->title;?>'s Logs</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'task-logs-grid',
        'dataProvider'=>$dataProvider,
        'columns'=>array(
                array('name'=>'id', 'value'=>'$data->id', 'type'=>'number'),
                array('name'=>'date_run', 'value'=>'$data->date_run', 'type'=>'dateTime'),
                'ip',
                array('name'=>'description', 'value'=>'$data->description', 'type'=>'raw'),
                array('class'=>'CButtonColumn', 'template'=>'{delete}', 'deleteButtonUrl'=>'Yii::app()->controller->createUrl("deleteLog",array("id"=>$data->primaryKey))',)
        ),
)); ?>

<div class="portlet" style="float: left;">
    <div class="portlet-decoration">
        <div class="portlet-title">
            <?php
            echo CHtml::ajaxLink('Delete All Logs',  $this->createUrl('deleteAllLogs', array('id'=>$task->id)),
                array(  // Ajax Option
                    'type'=>'GET',
                    'success'=>'function(){$("#task-logs-grid").hide(2500);}'
                ),
                array( //htmlOptions
                    'confirm'=>'Are you sure want to delete all logs?',
                )
            );
            ?>
        </div>
    </div>
</div>