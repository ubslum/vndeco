<?php
$this->pageTitle='Admin Control Panel - I18N';
$this->breadcrumbs=array(
        'ACP Home',
        'I18N',
        'Manage',
);
?>

<h1>Manage Langs</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'lang-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'columns'=>array(
                'id',
                'title',
                array(
                        'name'=>'default_lang',
                        'value'=>'$data->default_lang',
                        'type'=>'boolean',
                        'filter'=>array(1=>'Yes', 0=>'No'),
                ),
                array(
                        'class'=>'MyButtonColumn',
                        'template'=>'{update}{delete}',
                        'deleteButtonVisible'=>'$data->canDelete()',

                ),
        ),
)); ?>
