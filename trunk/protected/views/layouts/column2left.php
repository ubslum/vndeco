<?php $this->beginContent(); ?>
<div class="container">
    <div class="span-6 first">
        <div class="sidebar-left">
            <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Operations'),
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items' => $this->menu,
                'htmlOptions' => array('class' => 'operations'),
            ));
            $this->endWidget();
            ?>
            <?php $this->widget('WLeftCol'); ?>
        </div><!-- sidebar -->
    </div>
    <div class="span-18 last">
        <div id="content">
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('notice')): ?>
                <div class="flash-notice"><?php echo Yii::app()->user->getFlash('notice'); ?></div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('error')): ?>
                <div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
            <?php endif; ?>
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
</div>
<?php $this->endContent(); ?>