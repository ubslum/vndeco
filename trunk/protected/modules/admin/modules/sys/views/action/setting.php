<?php
$this->pageTitle='Admin Control Panel - System Information';
$this->breadcrumbs=array(
        'ACP Home',
        'System Information',
        'Edit settings',
);

?>

<h1>General settings</h1>
<?php $this->widget('WSettingWidget', array('group'=>'general'));?>