<?php

/**
 * ForgotUsernameForm Class
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ForgotPasswordForm extends CFormModel {

    public $user;
    public $email;
    public $verifyCode;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('email', 'length', 'max'=>256),
            array('email, verifyCode', 'required'),
            array('email', 'email'),
            array('email', 'checkExist'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!extension_loaded('gd')),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'email'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your Email'),
            'verifyCode'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Verification Code'),
        );
    }

    /**
     * Make sure new email do not exist in system
     * @param <type> $attribute
     * @param <type> $params
     */
    public function checkExist($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'email=:email';
        $criteria->params = array(':email'=>$this->email);
        $this->user = Account::model()->find($criteria);
        if (!$this->user) $this->addError('email', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'The email provided does not exist in our database!'));
    }
}