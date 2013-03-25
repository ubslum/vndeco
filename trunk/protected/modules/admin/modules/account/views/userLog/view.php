<?php
$this->breadcrumbs=array(
	'User Logs',
);


?>

<h1>User Logs</h1>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-log-grid',
    'dataProvider' => $model->sessionSearch(),
    'filter' => $model,
    'columns' => array(
        array('name' => 'time', 'value' => '$data->time', 'type' => 'dateTime'),
        'ip',
        'country',
        'log',
        'url',
    ),
));
?>
