<?php

/**
 * SetUsernameForm
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class SetUsernameForm extends CFormModel {

    public $username;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('username', 'length', 'min'=>3, 'max'=>32),
            array('username', 'match', 'pattern'=>'/^[A-Za-z0-9_ -]+$/', 'message'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Only alphanumeric characters, "_", "-" and "space" are allowed')),
            array('username', 'required'),
            array('username', 'checkUsername'),

        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'username'      => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Username'),
        );
    }

    /**
     * Make sure new email do not exist in system
     * @param <type> $attribute
     * @param <type> $params
     */
    public function checkUsername($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'username=:username';
        $criteria->params = array(':username'=>$this->username);
        $exist = Account::model()->find($criteria);
        if ($exist) $this->addError('username', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Username already exists.'));
    }
}