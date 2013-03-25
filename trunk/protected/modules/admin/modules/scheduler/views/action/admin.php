<?php
$this->pageTitle='Admin Control Panel - Scheduler';
$this->breadcrumbs=array(
        'ACP Home',
        'Schedulers',
        'Manage',
);
?>

<h1>Manage Schedulers</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'scheduler-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'columns'=>array(
                array('name'=>'id', 'value'=>'$data->id', 'type'=>'number', 'filter'=>FALSE),
                'title',
                'description',
                //'task_file',
                array('name'=>'last_run', 'value'=>'$data->last_run', 'type'=>'dateTime', 'filter'=>FALSE),
                array('name'=>'next_run', 'value'=>'$data->next_run', 'type'=>'dateTime', 'filter'=>FALSE),
                /*
		'week_day',
		'month',
		'month_day',
		'hour',
		'minute',
                */
                array('name'=>'run_one', 'value'=>'$data->run_one', 'type'=>'boolean', 'filter'=>array(0=>'No', 1=>'Yes')),
                array('name'=>'enabled', 'value'=>'$data->enabled', 'type'=>'boolean', 'filter'=>array(0=>'No', 1=>'Yes')),

                array(
                        'class'=>'CButtonColumn',
                        'headerHtmlOptions'=>array('width'=>80),
                        'template'=>'{run}{view}{update}{delete}',

                        'viewButtonUrl'=>'Yii::app()->controller->createUrl("taskLog",array("id"=>$data->primaryKey))',
                        'buttons'=>array('run'=>array('label'=>'Run now', 'imageUrl'=>Yii::app()->request->baseUrl.'/images/misc/task-run.png', 'url'=>'Yii::app()->createUrl("admin/scheduler/action/run", array("id"=>$data->id))')),
                ),
        ),
)); ?>
