<?php
/**
 * MyCaptcha
 * @author Gia Duy
 */
class MyCaptcha extends CCaptcha{
    /**
     * init the captch
     */
    public function init()
    {
        $this->clickableImage       = true;
        $this->showRefreshButton    = false;
        $this->imageOptions         = array('style'=>'cursor:pointer;', 'align'=>'left'); //middle,bottom,top,left,right
    }
}