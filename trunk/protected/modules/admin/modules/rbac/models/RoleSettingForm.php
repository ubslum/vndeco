<?php

/**
 * RoleSettingForm class.
 */
class RoleSettingForm extends CFormModel {

    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
                // name, email, subject and body are required
            array('name, email, subject, body, verifyCode', 'required'),
            // email has to be a valid email address
            array('email', 'email'),
            // verifyCode needs to be entered correctly
            array('verifyCode', 'captcha', 'allowEmpty'=>false),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'verifyCode'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Verification Code'),
            'name'          => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Name'),
            'email'         => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Email'),
            'subject'       => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Subject'),
            'body'          => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Message'),
        );
    }
}