<?php

/**
 * ChangeEmailForm
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ChangeEmailForm extends CFormModel {

    public $newEmail;
    public $verifyCode;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('newEmail', 'length', 'max'=>128),
            array('newEmail', 'required'),
            array('newEmail', 'email'),
            array('newEmail', 'checkEmail'),
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
            'newEmail'      => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'New Email'),
            'verifyCode'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Verification Code'),
        );
    }

    /**
     * Make sure new email do not exist in system
     * @param <type> $attribute
     * @param <type> $params
     */
    public function checkEmail($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'email=:email';
        $criteria->params = array(':email'=>$this->newEmail);
        $exist = Account::model()->find($criteria);
        if ($exist) $this->addError('newEmail', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'There is already an account associated with this email address.'));
    }
}