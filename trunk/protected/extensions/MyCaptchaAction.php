<?php
/**
 * MyCaptchaAction Class
 * @link http://www.greyneuron.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; greyneuron.com
 * @license http://www.greyneuron.com/code/license
 */
class MyCaptchaAction extends CCaptchaAction {
    //public $fixedVerifyCode='q!w@e#';
      public $transparent=true;
      public $testLimit=0;
//    public $maxLength=6;
//    public $minLength=4;
//    public $=70;
//    public $width=120;
//    public $foreColor=0x336629;
    
    public function __construct($controller, $id) {
        parent::__construct($controller, $id);
        $this->maxLength    = Yii::app()->params['captcha']['maxLength'];
        $this->minLength    = Yii::app()->params['captcha']['minLength'];
        $this->height       = Yii::app()->params['captcha']['height'];
        $this->width        = Yii::app()->params['captcha']['width'];
        $this->foreColor    = Yii::app()->params['captcha']['foreColor'];
    }
}