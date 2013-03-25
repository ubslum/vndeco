<?php
/**
 * MyWebModule Class
 * @author Gia Duy (admin@giaduy.info)
 */
class MyWebModule extends CWebModule{
    public function init() {
        /* layout path */
        if(isset(Yii::app()->theme->name)) $this->layoutPath = Yii::app()->theme->viewPath  . DIRECTORY_SEPARATOR . 'layouts';
        else $this->layoutPath = Yii::app()->layoutPath;
    }
}