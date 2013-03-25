<?php $this->widget('application.plugins.tooltip.Tooltip');?>
<div class="form">

    <?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'acc-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array('validateOnSubmit'=>true)
    )); 
    ?>

    <p class="note"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Fields with');?> <span class="required">*</span> <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'are required.');?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', array('size'=>32, 'maxlength'=>32)); ?>
        <img src="<?php echo Yii::app()->request->baseUrl;?>/images/misc/question.png" alt="<?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Help');?>" class="icon-tooltip" />
        <div class="tooltip"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your username.');?></div>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size'=>50, 'maxlength'=>128)); ?>
        <img src="<?php echo Yii::app()->request->baseUrl;?>/images/misc/question.png" alt="<?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Help');?>" class="icon-tooltip" />
        <div class="tooltip"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'We will send the activate code to this email address. For this reason, please make sure you enter a valid address where you can receive email.');?></div>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'emailAgain'); ?>
        <?php echo $form->textField($model, 'emailAgain', array('size'=>50, 'maxlength'=>128)); ?>
        <img src="<?php echo Yii::app()->request->baseUrl;?>/images/misc/question.png" alt="<?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Help');?>" class="icon-tooltip" />
        <div class="tooltip"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-enter your email address.');?></div>
        <?php echo $form->error($model, 'emailAgain'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size'=>32, 'maxlength'=>32)); ?>
        <img src="<?php echo Yii::app()->request->baseUrl;?>/images/misc/question.png" alt="<?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Help');?>" class="icon-tooltip" />
        <div class="tooltip"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your password.');?></div>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'passwordAgain'); ?>
        <?php echo $form->passwordField($model, 'passwordAgain', array('size'=>32, 'maxlength'=>32)); ?>
        <img src="<?php echo Yii::app()->request->baseUrl;?>/images/misc/question.png" alt="<?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Help');?>" class="icon-tooltip" />
        <div class="tooltip"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-enter your password.');?></div>
        <?php echo $form->error($model, 'passwordAgain'); ?>
    </div>

    <hr />

    <p class="note"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'In case you forget your username or password...');?></p>

    <div class="row">
        <?php echo $form->labelEx($model, 'secret_question'); ?>
        <?php echo $form->textField($model, 'secret_question', array('size'=>50, 'maxlength'=>256)); ?>
        <img src="<?php echo Yii::app()->request->baseUrl;?>/images/misc/question.png" alt="<?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Help');?>" class="icon-tooltip" />
        <div class="tooltip"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Write your secret question.');?></div>
        <?php echo $form->error($model, 'secret_question'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'answer_secret_question'); ?>
        <?php echo $form->textField($model, 'answer_secret_question', array('size'=>50, 'maxlength'=>256)); ?>
        <img src="<?php echo Yii::app()->request->baseUrl;?>/images/misc/question.png" alt="<?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Help');?>" class="icon-tooltip" />
        <div class="tooltip"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Write your answer.');?></div>
        <?php echo $form->error($model, 'answer_secret_question'); ?>
    </div>

    <hr />

    <p class="note"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Please make sure you are not robot');?></p>

    <div class="row">
        <?php echo $form->labelEx($model, 'verifyCode'); ?>
        <?php echo $form->textField($model, 'verifyCode'); ?>
        <img src="<?php echo Yii::app()->request->baseUrl;?>/images/misc/question.png" alt="<?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Help');?>" class="icon-tooltip" />
        <div class="tooltip"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Enter the verify code below.');?></div>
        <?php echo $form->error($model, 'verifyCode'); ?>
        <div style="clear:both"><?php $this->widget('MyCaptcha'); ?></div>
        <div class="hint">
            <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Please enter the letters as they are shown in the image above.');?><br/>
            <?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Letters are not case-sensitive.');?>
        </div>
    </div>

    <hr />
    <p class="note"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'By clicking the "Create My Account" button below, I certify that I have read and agree to the');?> <?php echo CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Terms'), Yii::app()->createUrl('site/page', array('view'=>'disclaimer')), array('target'=>'_blank', ));?>.</p>
    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Create My Account'), array('class'=>'glare-button')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->