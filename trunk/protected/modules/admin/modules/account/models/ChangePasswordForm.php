<?php

/**
 * ChangeEmailForm
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ChangePasswordForm extends CFormModel {

    public $newPass;
    public $newPassAgain;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('newPass, newPassAgain', 'required'),
            array('newPass, newPassAgain', 'length', 'max'=>32),
            array('newPassAgain', 'compare', 'compareAttribute'=>'newPass'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'newPass'       => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'New password'),
            'newPassAgain'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-enter new password'),
        );
    }
}