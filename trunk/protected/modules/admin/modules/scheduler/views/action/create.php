<?php
$this->pageTitle='Admin Control Panel - Scheduler';
$this->breadcrumbs=array(
        'ACP Home',
        'Schedulers',
        'Create task',
);

?>
<h1>Create new task</h1>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>