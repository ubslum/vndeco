<?php

/**
 * WRoleSetting Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WRoleSetting extends CWidget {
    public $data=array();
    //put your code here
    public function run()
    {
        $default=Yii::app()->params['roleSettings'];
        if(is_array($default))
            $this->data=array_merge($default, (array)$this->data);
        $this->render('wRoleSetting', array('data'=>$this->data));
    }
}