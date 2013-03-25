<?php
$this->pageTitle='Admin Control Panel - I18N';
$this->breadcrumbs=array(
        'ACP Home',
        'I18N',
        'Edit language'
);
?>
<h1>Update language <?php echo $model->title; ?></h1>
<?php echo $this->renderPartial('_form', array(
'model'=>$model,
'update'=>true,
)); ?>