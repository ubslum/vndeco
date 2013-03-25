<?php
$this->pageTitle='Admin Control Panel - Role-Based Access Control';
$this->breadcrumbs=array(
        'ACP Home',
        'Role-Based Access Control',
        'Create RBAC',
);
?>
<h1>Create an authorization item</h1>
<?php echo $this->renderPartial('_form', array(
'model'=>$model,
'update'=>false,
)); ?>
