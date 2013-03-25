<?php
$this->pageTitle='Admin Control Panel - Manage Accounts';
$this->breadcrumbs=array(
        'ACP Home',
        'Account Management',
        'Manage Accounts',
);
?>

<h1>Manage Accounts</h1>
<div class="flash-notice">
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.<br />
    Note: For date comparison, use format yyyy-mm-dd. Ex: 2010-06-15
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'user-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'nullDisplay'=>'<i>NULL</i>',
        'columns'=>array(
                array(
                    'name'=>'id',
                    'value'=>'$data->id',
                    'type'=>'number',
                ),
                'username',
                'email',
                array(
                        'name'=>'id_referral',
                        'value'=>'$data->ref?CHtml::link($data->ref->username?$data->ref->username:$data->ref->email, Yii::app()->createUrl("admin/account/act/view", array("id"=>$data->ref->id))):null',
                        'type'=>'raw',
                ),
                array(
                        'name'=>'date_joined',
                        'value'=>'$data->date_joined',
                        'type'=>'date',
                ),
                array(
                        'name'=>'type',
                        'value'=>'$data->typeText',
                        'filter'=>Account::getTypeOption(),
                ),
                array(
                        'name'=>'status',
                        'value'=>'$data->status?"Active":"Unactive"',
                        'filter'=>array(1=>'Active', 0=>'Unactive'),
                ),

                array(
                        'class'=>'MyButtonColumn',
                        'deleteButtonVisible'=>'$data->canDelete()',
                ),
        ),
)); ?>
