<?php
$this->pageTitle='Admin Control Panel - Scheduler';
$this->breadcrumbs=array(
        'ACP Home',
        'Schedulers',
        'Update task',
);
?>
<h1>Update Scheduler <?php echo $model->title; ?></h1>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>