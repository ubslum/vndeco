<?php
$this->pageTitle = 'Admin Control Panel - System Information';
$this->breadcrumbs = array(
    'ACP Home',
    'System Information',
    'View Email Queues',
);
$this->keywords = 'Email Queues';
$this->description = 'View All Email Queues';
?>

<h1>Manage Email Queues</h1>



<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'email-queue-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            'id',
            'to',
            'subject',
            array('name' => 'content', 'value' => 'nl2br($data->content)', 'type' => 'raw'), 
            array('name' => 'time_sent', 'value' => '$data->time_sent', 'type' => 'dateTime'), 
            array('name' => 'status', 'value' => '$data->statusText', 'filter' => EmailQueue::getStatusOption()),
            array('class'=>'CButtonColumn', 'template'=>'{delete}', 'deleteButtonUrl'=>'Yii::app()->controller->createUrl("deleteEmail",array("id"=>$data->primaryKey))',)
        ),
    ));
?>
