<?php

/**
 * DTinyMCE Class
 * @author Gia Duy (admin@giaduy.info)
 * http://tinymce.moxiecode.com/wiki.php/Configuration
 */
class DTinyMCE extends CInputWidget {

    /**
     * @var string URL where to look for TinyMCE assets.
     */
    public $scriptUrl;

    /**
     * TinyMCE options
     * @var array
     */
    public $options = array();

    /**
     * Init widget.
     */
    public function init() {
        list($this->name, $this->id) = $this->resolveNameId();

        if ($this->scriptUrl === null)
            $this->scriptUrl = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets', false, -1, YII_DEBUG);

        $this->registerClientScript();
    }

    /**
     * Run widget.
     */
    public function run() {
        if ($this->hasModel())
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        else
            echo CHtml::textArea($this->name, $this->value, $this->htmlOptions);
    }

    /**
     * Register CSS and Scripts.
     */
    protected function registerClientScript() {
        $id = $this->id;
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($this->scriptUrl . '/jquery.tinymce.js');
        
        $scriptUrl=$this->scriptUrl.'/tiny_mce.js';

        /* default config */
        $default=array(
            'language'=>$this->getLanguageCode(Yii::app()->language),
            'script_url'=>$scriptUrl,
        );
        $options=CJavaScript::encode($default+$this->options);
        
        $script='$("#'.$id.'").tinymce('.$options.')';
        $cs->registerScript(__CLASS__.'#'.$id, $script, CClientScript::POS_READY);
    }
    
    /**
     * get language code
     */
    protected function getLanguageCode($lang)
    {
        if($lang=='zh_cn') return 'zh-cn';
        return $lang;
    }

}
