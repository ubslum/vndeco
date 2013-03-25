<?php
$this->pageTitle='Admin Control Panel - Role-Based Access Control';
$this->breadcrumbs=array(
        'ACP Home',
        'Role-Based Access Control',
        'Manage',
);
?>

<h1>Manage Auth Items</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'auth-item-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'columns'=>array(
                'name',
                array('name'=>'type', 'value'=>'$data->getTypeText()', 'filter'=>$model->getTypeOptions(),),
                'description',
                /*'bizrule',
                'data',*/
                array(
                        'class'=>'MyButtonColumn',
                        'deleteButtonVisible'=>'$data->canDelete()',
                ),
        ),
)); ?>
