<?php

/**
 * RegisterForm
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class RegisterForm extends CFormModel {
    
    public $username;
    public $email;
    public $emailAgain;
    public $password;
    public $passwordAgain;
    public $secret_question;
    public $answer_secret_question;
    public $verifyCode;
   

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(

            array('username, email, emailAgain, password, passwordAgain, secret_question, answer_secret_question', 'required'),
            array('username', 'length', 'min'=>3, 'max'=>32),
            array('username', 'match', 'pattern'=>'/^[A-Za-z0-9_ -]+$/', 'message'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Only alphanumeric characters, "_", "-" and "space" are allowed')),
            array('username', 'uniqueUsername'),

            array('email, emailAgain', 'email'),
            array('email, emailAgain', 'length', 'max'=>100),
            array('email', 'uniqueEmail'),
            array('emailAgain', 'compare', 'compareAttribute'=>'email'),

            array('password, passwordAgain', 'length', 'min'=>6, 'max'=>32),
            array('passwordAgain', 'compare', 'compareAttribute'=>'password'),

            array('secret_question, answer_secret_question', 'length', 'min'=>3, 'max'=>256),
            // verifyCode needs to be entered correctly
            array('verifyCode', 'captcha', 'allowEmpty'=>false),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'username'                  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choose your username'),
            'email'                     => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your current email address'),
            'emailAgain'                => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-enter your email'),
            'password'                  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choose a password'),
            'passwordAgain'             => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-enter password'),
            'secret_question'           => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Secret question'),
            'answer_secret_question'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your answer'),
            'verifyCode'                => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Verification Code'),
        );
    }

    /**
     * Check if the email is available.
     * @param <type> $attribute
     * @param <type> $params
     */
    public function uniqueEmail($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'email=:email';
        $criteria->params = array(':email'=>$this->email);
        $exist = Account::model()->find($criteria);
        if ($exist) $this->addError('email', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'There is already an account associated with this email address'));
    }

    /**
     * Check if the username is available.
     * @param <type> $attribute
     * @param <type> $params
     */
    public function uniqueUsername($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'username=:username';
        $criteria->params = array(':username'=>$this->username);
        $exist = Account::model()->find($criteria);
        if ($exist) $this->addError('username', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'This username is not available'));
    }
}