<?php
$this->pageTitle='Admin Control Panel - '.$model->username;
$this->breadcrumbs=array(
        'ACP Home',
        'Account Management',
        $model->username
);
?>

<h1>View Account #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
                'id',
                'username',
                'email',
                array(
                        'label'=>$model->getAttributeLabel('date_joined'),
                        'type'=>'date',
                        'value'=>$model->date_joined
                ),
                'secret_question',
                'answer_secret_question',
                array(
                        'label'=>$model->getAttributeLabel('id_referral'),
                        'value'=>$model->ref?CHtml::link($model->ref->username?$model->ref->username:$model->ref->email, $this->createUrl('view', array('id'=>$model->ref->id))):null,
                        'type'=>'raw',
                ),
                array(
                        'label'=>'Role(s)',
                        'value'=>$roles?CHtml::listBox('roles', null, $roles, array('disabled'=>'disabled')):NUll,
                        'type'=>'raw',
                ),
                array(
                        'label'=>$model->getAttributeLabel('type'),
                        'value'=>$model->typeText,
                ),
                array(
                        'label'=>$model->getAttributeLabel('status'),
                        'value'=>$model->status?'Active':'Unactive',
                ),

        ),
)); ?>

<br />
<div class="portlet" style="float: left; padding-right: 10px;">
    <div class="portlet-decoration">
        <div class="portlet-title"><?php echo CHtml::link('Change Password', $this->createUrl('changePass', array('id'=>$model->id)));?></div>
    </div>
</div>

<div class="portlet" style="float: left; padding-right: 10px;">
    <div class="portlet-decoration">
        <div class="portlet-title"><?php echo CHtml::link('Update Info', $this->createUrl('update', array('id'=>$model->id)));?></div>
    </div>
</div>

<div class="portlet" style="float: left; padding-right: 10px;">
    <div class="portlet-decoration">
        <div class="portlet-title"><?php echo CHtml::link('Assign/Revoke Roles', $this->createUrl('hierarchy', array('id'=>$model->id)));?></div>
    </div>
</div>

<div class="portlet" style="float: left; padding-right: 10px;">
    <div class="portlet-decoration">
        <div class="portlet-title"><?php echo CHtml::link('View User Activity', Yii::app()->createUrl('admin/account/userLog/admin', array('UserLog[id_user]'=>$model->id)));?></div>
    </div>
</div>

<div class="portlet" style="float: left; padding-right: 10px;">
    <div class="portlet-decoration">
        <div class="portlet-title"><?php echo CHtml::link('Login', $this->createUrl('login', array('id'=>$model->id)));?></div>
    </div>
</div>