<?php $this->beginContent(); ?>
<div class="container">
    <div class="span-24 last">
        <div id="content">
            <?php if(Yii::app()->user->hasFlash('success')):?>
            <div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
            <?php endif;?>
            <?php if(Yii::app()->user->hasFlash('notice')):?>
            <div class="flash-notice"><?php echo Yii::app()->user->getFlash('notice'); ?></div>
            <?php endif;?>
            <?php if(Yii::app()->user->hasFlash('error')):?>
            <div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
            <?php endif;?>
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
</div>
<?php $this->endContent(); ?>