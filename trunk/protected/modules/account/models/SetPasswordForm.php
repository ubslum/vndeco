<?php

/**
 * SetPasswordForm
 * @author Gia Duy (admin@giaduy.info)
 */
class SetPasswordForm extends CFormModel {

    public $newPass;
    public $newPassAgain;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('newPass, newPassAgain', 'length', 'max'=>32),
            array('newPass, newPassAgain', 'required'),
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
            'newPass'       => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choose your password'),
            'newPassAgain'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-enter your password'),
        );
    }

}