<?php

/**
 * MyMenu Class
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
Yii::import('zii.widgets.CMenu');
class MyMenu extends CMenu {

    /**
     * Contsructing view paths for our portlet
     * @return array the directories containing the view files for this widget
     */
    public function getViewPath() {
        $class = new ReflectionClass(get_class($this));
        $path = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . Yii::app()->theme->name . DIRECTORY_SEPARATOR . 'views';
        if (is_dir($path))
            return $path;
        return parent::getViewPath();
    }

}