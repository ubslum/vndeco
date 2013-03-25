<?php

/**
 * AccountIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AccountIdentity extends CUserIdentity {
    const ERROR_UNACTIVE_ACCOUNT = 3;
    const ERROR_INVALID_LOGIN=4;

    private $_id;

    /**
     * Authenticate user
     * @return <type>
     */
    public function authenticate() {

        $username = strtolower($this->username);
        $account = Account::model()->find('LOWER(email)=?', array($username));
        if ($account === null) // no user
            $this->errorCode = self::ERROR_INVALID_LOGIN;
        else { // user found
            $this->setState('status', $account->status);
            
            if (!$account->validatePassword($this->password))
                $this->errorCode = self::ERROR_INVALID_LOGIN;
            else { // All OK
                $this->_id = $account->id;
                $this->username = $account->username ? $account->username : $account->email;
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return!$this->errorCode;
    }

    /**
     * Admin Authenticate user
     * @return <type>
     */
    public function adminAuthenticate() {

        $username = strtolower($this->username);
        $account = Account::model()->find('LOWER(email)=?', array($username));
        if ($account === null) // no user
            $this->errorCode = self::ERROR_INVALID_LOGIN;
        else { // user found
            $this->setState('status', $account->status);
            $this->_id = $account->id;
            $this->username = $account->username ? $account->username : $account->email;
            $this->errorCode = self::ERROR_NONE;
        }
        return!$this->errorCode;
    }    
    
    /**
     * Get ID of current
     * @return string the AccountID
     */
    public function getId() {
        return $this->_id;
    }

}