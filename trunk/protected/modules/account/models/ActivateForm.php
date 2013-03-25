<?php

/**
 * Active Account
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ActivateForm extends CFormModel {

    public $id;
    // Account ID
    public $code;

    // Active Code
    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('id', 'length', 'max'=>9),
            array('id', 'numerical', 'integerOnly'=>true),
            array('code', 'length', 'max'=>32),
            array('id, code', 'required'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'id'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account ID'),
            'code'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Activate Code'),
        );
    }
}