<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'settingWidget.js'));
Yii::app()->clientScript->registerCssFile(Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'settingWidget.css'));
Yii::app()->clientScript->registerCssFile(Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview/styles.css'); // gridview css
?>
<div class="grid-view">
    <table class="items">
        <?php
        foreach($settings as $n=>$setting) $content[$setting['name']]=$this->render('_settingWidget', array('setting'=>$setting, 'n'=>$n), $return=true);
        $this->widget('zii.widgets.jui.CJuiSortable', array(
                'tagName'=>'tbody',
                'items'=>$content,
                'itemTemplate'=>'{content}',
                'options'=>array(
                        //'axis'=>'y',
                        'handle'=>'.handle',
                        'update'=>'js:function(){
                            $("#ajax-saving").show();
                            var order = $(this).sortable("serialize");
                            $.ajax({
                                type: "GET",
                                url: $("#ajax_sort_url").val(),
                                data: order,
                                success: function() {$("#ajax-saving").fadeOut("slow")}
                            });                            
                        }',
                ),

        ));?>
    </table>
</div>
<?php echo CHtml::hiddenField('ajax_save_url', Yii::app()->createUrl('admin/setting/updateSetting'));?>
<?php echo CHtml::hiddenField('ajax_sort_url', Yii::app()->createUrl('admin/setting/sortSetting'));?>