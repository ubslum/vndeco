<?php
$this->pageTitle='Admin Control Panel - Role-Based Access Control';
$this->breadcrumbs=array(
        'ACP Home',
        'Role-Based Access Control',
        'Add/Remove children items',
);

Yii::app()->getClientScript()->registerCssFile(Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview/styles.css'); // gridview css
?>
<h1>Add/Remove children item for <?php echo CHtml::link($model->name,array('view','id'=>$model->name)); ?></h1>
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>AuthItem</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($authItems as $n=>$item): ?>
            <tr class="<?php echo $n%2?'even':'odd';?>">
                <td class="<?php echo $auth->hasItemChild($model->name, $item->name)?'left':'right'?>"><?php echo CHtml::link($item->name,array('hierarchy','id'=>$item->name)); ?></td>
                <td><?php echo CHtml::encode($item->typeText); ?></td>
                <td>
                        <?php if(!$auth->hasItemChild($model->name, $item->name)):?>
                            <?php if(!$auth->checktLoop($model->name, $item->name)):?>
                                <?php echo CHtml::link('Add',array('addChild','parent'=>$model->name, 'child'=>$item->name), array('class'=>'button')); ?>
                            <?php endif;?>
                        <?php else:?>
                            <?php echo CHtml::link('Remove',array('removeChild','parent'=>$model->name, 'child'=>$item->name), array('class'=>'button')); ?>
                        <?php endif;?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<style type="text/css">
    .left{
        text-align:left;
        font-weight:bold;
        color:green;

    }
    .left a:link, .left a:visited{
        font-weight:bold;
        color:green;

    }
    .right{
        text-align:right;
        font-weight:bold;
        color:gray;
    }
    .right a:link, .right a:visited{
        font-weight:bold;
        color:gray;

    }
</style>