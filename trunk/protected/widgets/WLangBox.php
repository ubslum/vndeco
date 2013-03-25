<?php
/**
 * WLangBox Class
 * @link http://www.greyneuron.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; greyneuron.com
 * @license http://www.greyneuron.com/code/license
 */
class WLangBox extends CWidget {
    public function run()
    {
        echo CHtml::beginForm();
        echo CHtml::dropDownList('set_lang', Yii::app()->language, Common::getLanguageList(), array('onchange'=>'this.form.submit()'));
        echo CHtml::endForm();
    }
}