<?php
/**
 * WSettingWidget Class
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class WSettingWidget extends CWidget {
    public $group;
    //put your code here
    public function run()
    {
        $sql='SELECT `name`, `title`, `description`, `value`, `group`, `order` FROM {{settings}} WHERE `group`="'.$this->group.'" ORDER BY `order`';
        $this->render('settingWidget',array('settings'=>Yii::app()->db->createCommand($sql)->queryAll()));
    }
}