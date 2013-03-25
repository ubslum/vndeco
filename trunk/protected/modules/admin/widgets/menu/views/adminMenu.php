<?php if($type=='sidebar'):?>
    <?php foreach($sidebarItems as $item):?>
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array('title'=>$item['name']));
        $this->widget('zii.widgets.CMenu', array('items'=>$item['items'], 'htmlOptions'=>array('class'=>'operations')));
        $this->endWidget();
        ?>
    <?php endforeach;?>
<?php endif;?>

<?php if($type=='top'):?>
    <?php $this->widget('zii.widgets.CMenu',array('items'=>$topMenus)); ?>
<?php endif;?>