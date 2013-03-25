<?php

/**
 * TwitterNewAccountForm class.
 */
class TwitterNewAccountForm extends CFormModel {

    public $username;
    public $email;
    public $emailAgain;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('username, email, emailAgain', 'required'),
            array('username', 'length', 'min' => 3, 'max' => 32),
            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_ -]+$/', 'message' => 'Only alphanumeric characters, "_", "-" and "space" are allowed'),
            array('username', 'uniqueUsername'),
            array('email, emailAgain', 'email'),
            array('email, emailAgain', 'length', 'max' => 256),
            array('email', 'uniqueEmail'),
            array('emailAgain', 'compare', 'compareAttribute' => 'email'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your username'),
            'email' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your current email address'),
            'emailAgain' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-enter your email'),
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
        $criteria->params = array(':email' => $this->email);
        $exist = Account::model()->find($criteria);
        if ($exist)
            $this->addError('email', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'There is already an account associated with this email address.'));
    }

    /**
     * Check if the username is available.
     * @param <type> $attribute
     * @param <type> $params
     */
    public function uniqueUsername($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'username=:username';
        $criteria->params = array(':username' => $this->username);
        $exist = Account::model()->find($criteria);
        if ($exist)
            $this->addError('username', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'This username is not available!'));
    }

    /**
     * Connect Account
     */
    public function connect() {
        $session = Yii::app()->getSession();
        $account = new Account();
        $account->username = $this->username;
        $account->email = $this->email;
        $account->type = Account::TYPE_TWITTER;
        $account->status = Account::STATUS_PENDING;
        if ($account->save()) {
            $account->sendActivateEmail(true);
            $tt = TwitterUser::model()->findByPk($session['accessToken']['user_id']);
            $tt->id_user = $account->id;
            if ($tt->save())
                return $this->login();
            return false;
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        $session = Yii::app()->getSession();
        if ($this->_identity === null) {
            $this->_identity = new TwitterIdentity($session['accessToken']);
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
