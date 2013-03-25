<?php
$this->pageTitle='Admin Control Panel - Poll';
$this->breadcrumbs=array(
        'ACP Home',
        'Poll',
        'Create',
);
?>

<h1>Create Poll</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>