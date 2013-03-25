<?php
$this->pageTitle='Admin Control Panel - System Information';
$this->breadcrumbs=array(
        'ACP Home',
        'System Information',
        'User Agents',
);

?>

<h1>View User Agents</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'counter-user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'user_ip',
                array('name'=>'user_time', 'value'=>'$data->user_time', 'type'=>'dateTime'),
                'user_agent',
	),
)); ?>
