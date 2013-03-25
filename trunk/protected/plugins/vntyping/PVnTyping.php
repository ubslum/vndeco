<?php
/**
 * PVnTyping Class
 * @author Gia Duy (admin@giaduy.info)
 */
class PVnTyping extends CWidget {

    public function init() {
        parent::init();
        $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($assets . '/him.js');
        $cs->registerScriptFile($assets . '/typingupdate.js');
        $cs->registerScript('typingupdate', 'typingupdate2();', CClientScript::POS_LOAD);
    }

    public function run() {
?>
<div align="right">
    Bộ Gõ (F12): <a href="javascript:void(0)" onclick="on_off=1-on_off; typingupdate2();"><span id="vn_on_off" style="display: inline; font-weight: bold;">OFF</span></a> | Kiểu Gõ (F9): <a href="javascript:void(0)" onclick="on_off=1; method++ ; method %= 5; typingupdate2();"><span id="vn_mode" style="display: inline; font-weight: bold;">NONE</span></a>
</div>
<?php
    }

}