<?php

/**
 * ExtIdentity Class
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ExtIdentity extends CUserIdentity {

    private $_id;
    protected $email;

    /**
     * Constructor.
     * @param string username
     * @param string password
     */
    public function __construct($email) {
        $this->email = $email;
    }

    /**
     * Authenticate user
     * @return <type>
     */
    public function authenticate() {
        $email = strtolower($this->email);
        $account = Account::model()->find('LOWER(email)=?', array($email));
        if ($account === null) { // no user
            $session = Yii::app()->getSession();

            $account = new Account();
            $account->email = $email;
            $account->type = $session['loginType'];
            $account->save();
        }

        $this->_id = $account->id;
        $this->setState('status', $account->status);
        /* no username */
        if($account->username==null)
        {
            $this->username = $account->email;
            $session=Yii::app()->getSession();
            $session['noUsername']=true;
        }
        else $this->username=$account->username;
        
        $this->errorCode = self::ERROR_NONE;
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