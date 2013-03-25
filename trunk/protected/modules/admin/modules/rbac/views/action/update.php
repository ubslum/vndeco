<?php
$this->pageTitle='Admin Control Panel - Role-Based Access Control';
$this->breadcrumbs=array(
        'ACP Home',
        'Role-Based Access Control',
        'Update RBAC',
);
?>
<h1>Update authorization item: <?php echo $model->name; ?></h1>
<?php echo $this->renderPartial('_form', array(
'model'=>$model,
'update'=>true,
)); ?>