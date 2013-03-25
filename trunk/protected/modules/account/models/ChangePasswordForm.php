<?php

/**
 * ChangeEmailForm
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ChangePasswordForm extends CFormModel {

    public $currentPass;
    public $newPass;
    public $newPassAgain;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('currentPass, newPass, newPassAgain', 'length', 'max'=>32),
            array('currentPass, newPass, newPassAgain', 'required'),
            array('newPassAgain', 'compare', 'compareAttribute'=>'newPass'),
            array('currentPass', 'checkPassword'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'currentPass'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Current password'),
            'newPass'       => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'New password'),
            'newPassAgain'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-enter new password'),
        );
    }

    /**
     * Check current password
     * @param <type> $attribute
     * @param <type> $params
     */
    public function checkPassword($attribute, $params) {
        $user = Account::model()->findByPk(Yii::app()->user->id);
        if (!$user->validatePassword($this->currentPass)) $this->addError('currentPass', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Current password is not correct.'));
    }
}