<?php

/**
 * ResendActivateEmailForm Account
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ResendActivateEmailForm extends CFormModel {

    public $email;
    public $account;
    public $verifyCode;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('email', 'length', 'max'=>256),
            array('email', 'email'),
            array('email', 'required'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!extension_loaded('gd')),
            array('email', 'isUnVerify', 'skipOnError'=>true),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'email'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your Email'),
            'verifyCode'=> Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Verification Code'),
        );
    }
    
    public function isUnVerify($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'email=:email';
        $criteria->params = array(':email'=>$this->email);
        $this->account = Account::model()->find($criteria);
        if (!$this->account) $this->addError('email', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'The email provided does not exist in our database!'));
        else {
            if($this->account->type!=Account::TYPE_REGULAR) $this->addError('email', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Please log in through the third party account you previously used.'));
            if($this->account->activate_code === null) $this->addError('email', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'This account is already activated!'));            
        }
    }
}