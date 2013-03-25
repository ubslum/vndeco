<?php

/**
 * TwitterIdentity Class
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class TwitterIdentity extends CUserIdentity {

    private $_id;
    protected $accessToken = array();
    const NEW_CONNECT=5;
    
    /**
     * Constructor.
     * @param string username
     * @param string password
     */
    public function __construct($accessToken) {
        $this->accessToken = $accessToken;
    }

    /**
     * Authenticate user
     * @return <type>
     */
    public function authenticate() {
        $session = Yii::app()->getSession();
        
        $cri = new CDbCriteria();
        $cri->condition = 'id_twitter=:id_twitter';
        $cri->params = array(':id_twitter' => $this->accessToken['user_id']);
        $twitter = TwitterUser::model()->find($cri);

        /* Twitter info */
        if (!$twitter)
            $twitter = new TwitterUser();
        $twitter->id_twitter = $this->accessToken['user_id'];
        $twitter->oauth_token = $this->accessToken['oauth_token'];
        $twitter->oauth_token_secret = $this->accessToken['oauth_token_secret'];
        $twitter->screen_name = $this->accessToken['screen_name'];
        $twitter->save();

        /* frist login */
        if($twitter->id_user==null) $this->errorCode = self::NEW_CONNECT;
        
        /* already connect */
        else {
            $account=Account::model()->find('id=?', array($twitter->id_user));
            if($account)
            {
                $this->_id = $account->id;
                $this->username = $account->username;
                $this->errorCode = self::ERROR_NONE;
                $this->setState('status', $account->status);
            }
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