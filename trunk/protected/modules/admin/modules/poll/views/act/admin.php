<?php
$this->pageTitle='Admin Control Panel - Poll';
$this->breadcrumbs=array(
        'ACP Home',
        'Poll',
        'Manage',
);
?>

<h1>Manage Polls</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'poll-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            'id',
            'title',
            
            'description',
            'date_created',
            'date_begin',
            'date_end',
            'date_show_result',
            array('name'=>'status', 'value'=>'$data->statusText', 'filter'=>Poll::getStatusOption()),
            array(
                'class' => 'CButtonColumn',
            ),
        ),
    ));
?>
