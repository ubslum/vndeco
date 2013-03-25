<?php
$this->pageTitle='Admin Control Panel - System Information';
$this->breadcrumbs=array(
        'ACP Home',
        'System Information',
        'View Error Logs',
        '#'.$model->id,
);
?>

<h1>View Log #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'level',
		'category',		
                array('name'=>$model->getAttributeLabel('logtime'), 'value'=>$model->logtime, 'type'=>'dateTime'),
                array('name'=>'message', 'value'=>$model->message, 'type'=>'ntext'),
	),
)); ?>
