<?php
$this->pageTitle='Admin Control Panel - I18N';
$this->breadcrumbs=array(
    'ACP Home',
    'I18N',
    'Add new languages'
);
?>
<h1>Add new language</h1>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>