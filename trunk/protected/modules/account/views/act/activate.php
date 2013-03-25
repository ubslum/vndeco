<?php
$this->pageTitle=Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Activate Account');
$this->breadcrumbs=array(
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
    Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Activation'),
);
$this->keywords=Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'activation');
$this->description=Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Activation');
?>

<?php if(Yii::app()->user->hasFlash('success')):?>
<div class="login-box">
    <div align="center" class="center">
        <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your account is ready');?>
    </div>
</div>
<?php else:?>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array('id'=>'activate-form', 'enableAjaxValidation'=>true, 'enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true))); ?>
    <div class="row">
            <?php echo $form->labelEx($model, 'id'); ?>
            <?php echo $form->textField($model, 'id'); ?>
            <?php echo $form->error($model, 'id'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model, 'code'); ?>
            <?php echo $form->textField($model, 'code', array('size'=>34, 'maxlength'=>32)); ?>
            <?php echo $form->error($model, 'code'); ?>
    </div>
    <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Activate'), array('class'=>'glare-button')); ?>
    </div>
        <?php $this->endWidget();?>
</div>
<?php endif;?>