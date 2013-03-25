<?php
$this->breadcrumbs = array(
    'User Logs' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List UserLog', 'url' => array('index')),
    array('label' => 'Create UserLog', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage User Logs</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-log-grid',
    //'ajaxUpdate'=>false,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        
        array('name' => 'id_user', 'value' => '$data->id_user?$data->id_user." - ".$data->account->username:""'),
        'session',
        array('name' => 'time', 'value' => '$data->time', 'type' => 'dateTime'),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("session"=>$data->session))',
        ),
    ),
));
?>
