<?php

/**
 * TwitterConnectForm class.
 */
class TwitterConnectForm extends CFormModel {

    public $email;
    public $password;
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
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe'=> Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Remember me next time'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors())  // we only want to authenticate when no input errors
        {
            $this->_identity = new AccountIdentity($this->email, $this->password);
            $this->_identity->authenticate();
            switch ($this->_identity->errorCode) {
                case AccountIdentity::ERROR_UNACTIVE_ACCOUNT:
                    $this->addError('error', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your account is not activate.'));
                    break;
                case AccountIdentity::ERROR_INVALID_LOGIN:
                    $this->addError('error', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid email or password, please try again.'));
                    break;
                default:
                    break;
            }
        }
    }
    
    /**
     * Connect Account
     */
    public function connect()
    {
        $session = Yii::app()->getSession();
        $account = Account::model()->find('LOWER(email)=?', array($this->email));
        if($account)
        {
            $tt=TwitterUser::model()->findByPk($session['accessToken']['user_id']);
            $tt->id_user=$account->id;
            if($tt->save()) return $this->login();
        }
        return false;
        
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
            $duration = 3600 * 24 * 30; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        else
            return false;
    }    
}
