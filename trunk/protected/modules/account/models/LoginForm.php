<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {

    public $email;
    public $password;
    public $rememberMe;
    public $error;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('email, password', 'required'),
            array('email', 'email'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'email' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Email'),
            'password' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Password'),
            'rememberMe' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Remember me next time'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {  // we only want to authenticate when no input errors
            $identity = new AccountIdentity($this->email, $this->password);
            $identity->authenticate();
            switch ($identity->errorCode) {
                case AccountIdentity::ERROR_INVALID_LOGIN:
                    $this->addError('error', Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Invalid email or password, please try again.'));
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new AccountIdentity($this->email, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === AccountIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        else
            return false;
    }

}
