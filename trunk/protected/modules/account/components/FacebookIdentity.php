<?php

/**
 * FacebookIdentity
 * @author Gia Duy (admin@giaduy.info)
 */
class FacebookIdentity extends CUserIdentity {

    private $_id;
    protected $userInfo = array();
    protected $fu; // facebook user

    /**
     * Constructor.
     * @param string username
     * @param string password
     */

    public function __construct($userInfo) {
        $this->userInfo = $userInfo;
        /* save,update facebook user */
        $this->fu = FacebookUser::model()->findByPk($this->userInfo['id']);
        if (!$this->fu)
            $this->fu = new FacebookUser();
        $this->fu->id_facebook = $this->userInfo['id'];
        $this->fu->name = $this->userInfo['name'];
        $this->fu->email = $this->userInfo['email'];
        $this->fu->access_token = $this->userInfo['access_token'];
    }

    /**
     * Authenticate user
     * @return <type>
     */
    public function authenticate() {
        /* first login, check if same email or create new account */
        if ($this->fu->id_user == null) {
            $email = strtolower($this->fu->email);
            $account = Account::model()->find('LOWER(email)=?', array($email));
            if ($account === null) { // no user
                $account = new Account();
                $account->email = $email;
                $account->type = Account::TYPE_FACEBOOK;
                $account->status = $this->userInfo['verified'] ? Account::STATUS_ACTIVATED : Account::STATUS_PENDING;
                $account->save();
                $this->session['noUsername'] = true;
            }
            $this->fu->id_user=$account->id;
        }
        
        else{
            $account = Account::model()->findByPk($this->fu->id_user);
        }


        $this->_id = $account->id;
        $this->setState('status', $account->status);
        /* no username */
        if ($account->username == null) {
            $this->username = $this->fu->name;
            $this->session['noUsername'] = true;
        }
        else
            $this->username = $account->username;

        $this->errorCode = self::ERROR_NONE;
        $this->fu->save();
        return!$this->errorCode;
    }

    /**
     * Connect facebook account to our system account
     */
    public function connectAccount()
    {
        $this->fu->id_user=Yii::app()->user->id;
        $this->fu->save();
    }

        /**
     * Get ID of current
     * @return string the AccountID
     */
    public function getId() {
        return $this->_id;
    }

}