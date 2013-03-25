<?php $this->pageTitle=Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Error');?>
<br />
<div class="flash-error">
    <div><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Sorry, an error occurred. If you are unsure on how to use a feature, or do not know why you got this error message, please {CONTACT_LINK} for more information.', array('{CONTACT_LINK}'=>CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'contact us'), Yii::app()->createUrl('site/contact'))));?></div>
<div><br /></div>
<div><b><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Error');?> <?php echo CHtml::encode($code.': '.$message); ?></b></div>
</div>
<div align="center">
    <a href="javascript: history.go(-1)"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Go Back');?></a> - <a href="<?php echo Yii::app()->createUrl('site/index');?>"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Home Page');?></a>
</div>
