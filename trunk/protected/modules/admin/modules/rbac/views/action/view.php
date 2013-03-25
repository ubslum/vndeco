<?php
$this->pageTitle='Admin Control Panel - Role-Based Access Control';
$this->breadcrumbs=array(
        'ACP Home',
        'Role-Based Access Control',
        'View item',
);
Yii::app()->getClientScript()->registerCssFile(Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/detailview/styles.css'); // gridview css
?>
<h1>View item: <?php echo $model->name; ?></h1>
<table class="detail-view">
    <tbody>
        <tr class="even">
            <th><?php echo CHtml::encode($model->getAttributeLabel('name')); ?></th>
            <td><?php echo CHtml::encode($model->name); ?></td>
        </tr>
        <tr class="odd">
            <th><?php echo CHtml::encode($model->getAttributeLabel('type')); ?></th>
            <td><?php echo CHtml::encode($model->typeText); ?></td>
        </tr>
        <tr class="even">
            <th><?php echo CHtml::encode($model->getAttributeLabel('description')); ?></th>
            <td><?php echo CHtml::encode($model->description); ?></td>
        </tr>
        <tr class="odd">
            <th><?php echo CHtml::encode($model->getAttributeLabel('bizrule')); ?></th>
            <td><?php echo CHtml::encode($model->bizrule);?></td>
        </tr>
        <tr class="even">
            <th><?php echo CHtml::encode($model->getAttributeLabel('data')); ?></th>
            <td><?php echo CHtml::encode($model->data); ?></td>
        </tr>
        <tr class="odd">
            <th><?php echo CHtml::encode('Children Items'); ?></th>
            <td>
                <?php foreach($model->itemChild as $item): ?>
                <div><?php echo CHtml::link($item->child,array('view','id'=>$item->child)); ?></div>
                <?php endforeach;?>
                &nbsp;
            </td>
        </tr>
    </tbody>
</table>

<br />
<div class="portlet" style="float: left; padding-right: 10px;">
    <div class="portlet-decoration">
        <div class="portlet-title">
                <?php echo CHtml::link('Add/Remove children items', array('hierarchy','id'=>$model->name), array('class'=>'button'));?>
        </div>
    </div>
</div>

<div class="portlet" style="float: left; padding-right: 10px;">
    <div class="portlet-decoration">
        <div class="portlet-title">
                <?php echo CHtml::link('Edit Item', array('update','id'=>$model->name), array('class'=>'button'));?>
        </div>
    </div>
</div>