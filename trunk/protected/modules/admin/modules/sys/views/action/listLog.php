<?php
$this->pageTitle='Admin Control Panel - System Information';
$this->breadcrumbs=array(
        'ACP Home',
        'System Information',
        'View Error Logs',
);
?>

<h1>View System Logs</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'log-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'columns'=>array(
                array('name'=>'id', 'value'=>'$data->id', 'type'=>'number'),
                'level',
                'category',
                array('name'=>'logtime', 'value'=>'$data->logtime', 'type'=>'dateTime', 'filter'=>FALSE),

                array(
                        'class'=>'CButtonColumn',
                        'template'=>'{view}',
                        'viewButtonUrl'=>'Yii::app()->controller->createUrl("viewLog",array("id"=>$data->primaryKey))',
                ),
        ),
)); ?>

<div class="portlet" style="float: left;">
    <div class="portlet-decoration">
        <div class="portlet-title">
            <?php
            echo CHtml::ajaxLink('Delete All Logs',  $this->createUrl('deleteAllLogs'),
                array(  // Ajax Option
                    'type'=>'GET',
                    'success'=>'function(){$("#log-grid").hide(2500);}'
                ),
                array( //htmlOptions
                    'confirm'=>'Are you sure want to delete all logs?',
                )
            );
            ?>
        </div>
    </div>
</div>