<?php

/**
 * WAddThis Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WAddThis extends CWidget {

    public $style='addthis_16x16_style';
    public $separator='';

    public function init() {
        parent::init();
        //return;
        $script = 'var addthis_config = {services_exclude:"facebook,twitter", ui_language: "' . $this->getLanguageCode(Yii::app()->language) . '"}';
        Yii::app()->clientScript->registerScriptFile('http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4cb7e24f32666ed1');
        Yii::app()->clientScript->registerScript('addthis', $script, CClientScript::POS_END);
    }

    public function run() {
            $this->display();
    }



    public function display() {
        ?>
        <div class="add-this">
            <div class="addthis_toolbox addthis_default_style <?php echo $this->style;?>">
                <?php echo CHtml::link('<span class="at300bs at15t_facebook"></span>', 'http://www.' . Yii::app()->params['facebook']['fbUrl'] . '/share.php?u=' . Common::getCurrentUrl(), array('target' => '_blank', 'title' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Send to Facebook'), 'rel' => 'nofollow')); ?><?php echo $this->separator;?>
                <a class="addthis_button_twitter"></a><?php echo $this->separator;?>
                <a class="addthis_button_email"></a><?php echo $this->separator;?>
                <a class="addthis_button_google"></a><?php echo $this->separator;?>
                <a class="addthis_button_compact"></a><?php echo $this->separator;?>
                <a class="addthis_button_google_plusone" g:plusone:size="small"></a>
            </div>
        </div>
        <?php
    }

    /**
     * Get addthis language code
     * @param string $language
     * @return string langauge code
     */
    protected function getLanguageCode($language)
    {
        if(in_array($language, array('zh_cn', 'zh_hans', 'zh_hans_cn', 'zh_hans_hk', 'zh_hans_mo', 'zh_hans_sg', 'zh_hant', 'zh_hant_hk', 'zh_hant_mo', 'zh_hant_tw', 'zh_hk', 'zh_mo', 'zh_sg', 'zh_tw'))) return 'zh';
        return $language;
    }
   
}