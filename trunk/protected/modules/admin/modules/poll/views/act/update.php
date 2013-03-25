<?php
$this->pageTitle='Admin Control Panel - Poll';
$this->breadcrumbs=array(
        'ACP Home',
        'Poll',
        'Update',
        'Poll #'.$model->id,
);
?>

<h1>Update Poll #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>