<?php
$this->pageTitle='Admin Control Panel - Assigns authorization';
$this->breadcrumbs=array(
        'ACP Home',
        'Account Management',
        $model->username,
        'Assigns authorization'
);
Yii::app()->getClientScript()->registerCssFile(Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview/styles.css'); // gridview css
?>

<h1>Assigns authorization items to user <?php echo $model->username;?></h1>
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>AuthItem</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($auth->Roles as $n=>$item): ?>
            <tr class="<?php echo $n%2?'even':'odd';?>">
                <td class="<?php echo ($auth->getAuthAssignment($item->name, $model->id))?'left':'right'?>">
                        <?php echo CHtml::link($item->name,Yii::app()->createUrl('admin/rbac/action/show',array('id'=>$item->name))); ?>
                </td>
                <td><?php echo CHtml::encode($item->description); ?></td>
                <td>
                        <?php if(!$auth->getAuthAssignment($item->name, $model->id)):?>
                            <?php echo CHtml::link('Assign',array('assign','item'=>$item->name, 'user'=>$model->id), array('class'=>'button')); ?>
                        <?php else:?>
                            <?php echo CHtml::link('Revoke',array('revoke','item'=>$item->name, 'user'=>$model->id), array('class'=>'button')); ?>
                        <?php endif;?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div align="center">
    <div class="portlet" style="width: 100px;">
        <div class="portlet-decoration">
            <div class="portlet-title"><?php echo CHtml::link('Done', $this->createUrl('view', array('id'=>$model->id)));?></div>
        </div>
    </div>
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