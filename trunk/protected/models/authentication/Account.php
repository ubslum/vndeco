<?php

class Account extends CActiveRecord {

    const STATUS_ACTIVATED = 1;
    const STATUS_PENDING = 0;
    const TYPE_REGULAR = 1;
    const TYPE_GOOGLE = 2;
    const TYPE_YAHOO = 3;
    const TYPE_FACEBOOK = 4;
    const TYPE_TWITTER = 5;

    /**
     * Get Type Text
     * @return string Status Text
     */
    public function getTypeText() {
        switch ($this->type) {
            case self::TYPE_REGULAR: return Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Regular');
                break;
            case self::TYPE_GOOGLE: return Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Google');
                break;
            case self::TYPE_YAHOO: return Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Yahoo');
                break;
            case self::TYPE_FACEBOOK: return Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Facebook');
                break;
            case self::TYPE_TWITTER: return Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Twitter');
                break;
            default: return Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Unknown');
                break;
        }
    }

    /**
     * Get Type Text
     * @return string Status Text
     */
    public static function getTypeOption() {
        return array(
            self::TYPE_REGULAR => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Regular'),
            self::TYPE_GOOGLE => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Google'),
            self::TYPE_YAHOO => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Yahoo'),
            self::TYPE_FACEBOOK => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Facebook'),
            self::TYPE_TWITTER => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Twitter')
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{accounts}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('email', 'required'),
            array('email', 'email'),
            array('username, email', 'unique'),
            array('date_joined, id_referral, status', 'numerical', 'integerOnly' => true),
            array('seo_name, username, email', 'length', 'max' => 32, 'min' => 3),
            array('password, salt', 'length', 'max' => 32),
            array('secret_question, answer_secret_question', 'length', 'max' => 256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, seo_name, username, email, id_referral, date_joined, type, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ref' => array(self::BELONGS_TO, 'Account', 'id_referral', 'select' => 'id, username, email'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'ID'),
            'seo_name' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Seo Name'),
            'username' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Username'),
            'email' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Email'),
            'password' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Password'),
            'date_joined' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Date Joined'),
            'secret_question' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Secret Question'),
            'answer_secret_question' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Answer'),
            'type' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account Type'),
            'status' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Status'),
            'id_referral' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Referral'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);

        $criteria->compare('seo_name', $this->seo_name, true);

        $criteria->compare('username', $this->username, true);

        $criteria->compare('email', $this->email, true);

        $criteria->compare('id_referral', $this->id_referral, true);

        $criteria->compare('FROM_UNIXTIME(date_joined, "%Y-%m-%d")', $this->date_joined);

        $criteria->compare('type', $this->type, true);

        $criteria->compare('status', $this->status);

        return new CActiveDataProvider('Account', array(
                    'criteria' => $criteria,
                    'pagination' => array('pageSize' => Yii::app()->params['settings']['bigPageSize'])
                ));
    }

    /**
     * Generate time and encode the password
     * @return <type>
     */
    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->date_joined = time();

            /* Regular */
            if ($this->type == Account::TYPE_REGULAR) {
                $this->status = 0;
                $this->salt = $this->saltPassword();
                $this->activate_code = md5(time());
                $this->password = md5($this->password . $this->salt);
            }
            /* Register from openid/facebook/twitter */ else if ($this->status === null)
                $this->status = 1;
        }
        if ($this->username == '')
            $this->username = null;
        $this->seo_name = ContentHandler::url_friendly_name($this->username ? $this->username : $this->email);
        return TRUE;
    }

    /**
     * check if the user has entered a valid password
     * @param <type> $password
     * @return <type>
     */
    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    /**
     * hash results
     * @param <type> $password
     * @param <type> $salt
     * @return <type>
     */
    public function hashPassword($password, $salt) {
        return md5($password . $salt);
    }

    /**
     * generate salt string
     * @return <type>
     */
    protected function saltPassword() {
        // Create a SHA1 hash
        $salt = sha1('~' . $this->email . '~' . microtime(TRUE) . '~');
        // Limit to random 16 characters in the hash
        $salt = substr($salt, rand(0, 30), 16);
        return $salt;
    }

    /**
     * set password
     * @param string encoded $password 
     */
    public function setPassword($password) {
        if ($this->salt == null)
            $this->salt = $this->saltPassword();
        $this->password = $this->hashPassword($password, $this->salt);
    }

    /**
     * send activate email
     * @return <type>
     */
    public function sendActivateEmail($generateCode = false) {
        if ($generateCode === true) {
            $this->activate_code = md5(time());
            $this->save();
        }

        if ($this->activate_code) {
            $content = Common::getEmailMessage('activateAccount', Yii::app()->findModule('account')->basePath);
            $contentFooter = Common::getSetting('emailFooter');

            $appName = Yii::app()->name;
            $username = $this->username;
            $userId = $this->id;
            $activateDirectLink = Common::generateHyperLink(Yii::app()->createUrl('account/act/activate', array('id' => $this->id, 'code' => $this->activate_code)));
            $activateLink = Common::generateHyperLink(Yii::app()->createUrl('account/act/activate'));
            $activateCode = $this->activate_code;
            $contactEmail = Common::getSetting('adminEmail');

            $email = new Email();
            $email->AddAddress($this->email);
            $email->Subject = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Action Required to Activate Membership for {appName}', array('{appName}' => $appName));
            $email->Body = Common::translateMessage($content, array('{username}' => $username, '{userId}' => $userId, '{appName}' => $appName, '{activateDirectLink}' => $activateDirectLink, '{activateLink}' => $activateLink, '{activateCode}' => $activateCode, '{contactEmail}' => $contactEmail));
            $email->Body .= $contentFooter;
            if ($email->Send())
                return true;
            return false;
        }
    }

    /**
     * Activate this accoint
     * @param <string> $code
     * @return <boolean> TRUE or FALSE
     */
    public function activate($code) {
        if ($this->activate_code === $code) {
            $this->activate_code = null;
            $this->status = Account::STATUS_ACTIVATED;
            $this->save();
            /* remove flash message */
            Yii::app()->user->setFlash('notice', null);
            //Yii::app()->user->status=Account::STATUS_ACTIVATED;
            /* auto login */
            $identity = new AccountIdentity($this->email, $this->password);
            $identity->adminAuthenticate();
            Yii::app()->user->login($identity, 0);
            return true;
        }
        return false;
    }

    /**
     * De-activate account (when change email)
     * @param <boolean> $sendMail want to sent active mail?
     * @return <boolean>
     */
    public function deActivate($sendMail = true) {
        $this->activate_code = md5(time());
        $this->status = 0;
        if ($this->save()) {
            if ($sendMail === true)
                $this->sendActivateEmail();
            return true;
        }
        return false;
    }

    /**
     * Reset password
     * @return <type>
     */
    public function resetPassword() {
        $this->reset_pass_key = md5(time());
        if ($this->save()) {
            $content = Common::getEmailMessage('resetPassword', Yii::app()->findModule('account')->basePath);
            $contentFooter = Common::getSetting('emailFooter');

            $appName = Yii::app()->name;
            $username = $this->username;
            $resetPassLink = Common::generateHyperLink(Yii::app()->createUrl('account/act/resetPass', array('id' => $this->id, 'key' => $this->reset_pass_key)));

            $email = new Email();
            $email->AddAddress($this->email);
            $email->Subject = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Password recovery information');
            $email->Body = Common::translateMessage($content, array('{appName}' => $appName, '{username}' => $username, '{resetPassLink}' => $resetPassLink));
            $email->Body .= $contentFooter;
            if ($email->Send())
                return true;
            return false;
        }
        return false;
    }

    /**
     * Send new password to user
     * @param <type> $key
     * @return <type>
     */
    public function sendNewPassword($key) {
        if ($this->reset_pass_key === $key) {
            $pass = time();
            $this->reset_pass_key = null;
            if ($this->salt == null)
                $this->salt = $this->saltPassword();
            $this->password = $this->hashPassword($pass, $this->salt);
            $this->save();

            /* Send pass */
            $content = Common::getEmailMessage('sendPassword', Yii::app()->findModule('account')->basePath);
            $contentFooter = Common::getSetting('emailFooter');

            $appName = Yii::app()->name;
            $username = $this->username;
            $login = $this->email;
            $password = $pass;
            $changePassLink = Common::generateHyperLink(Yii::app()->createUrl('account/act/changePassword'));

            $email = new Email();
            $email->AddAddress($this->email);
            $email->Subject = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your new password for {appName}', array('{appName}' => $appName));
            $email->Body = Common::translateMessage($content, array('{appName}' => $appName, '{username}' => $username, '{login}' => $login, '{password}' => $password, '{changePassLink}' => $changePassLink));
            $email->Body .= $contentFooter;
            if ($email->Send())
                return true;
            return false;

            /* END: Send pass */
        }
        return false;
    }

    /**
     * Root cant be deleted
     * @return boolean
     */
    public function canDelete() {
        return !Yii::app()->authManager->checkAccess('Root', $this->id);
    }

    /**
     * Suggests a list of existing user matching the specified keyword.
     * @param string the keyword to be matched
     * @param integer maximum number of users to be returned
     * @return array list of matching user names
     */
    public function suggestAccounts($keyword, $limit = 20) {
        $users = $this->findAll(array(
            'condition' => 'username LIKE :keyword',
            'order' => 'username',
            'limit' => $limit,
            'params' => array(
                ':keyword' => "%$keyword%",
            ),
                ));
        $names = array();
        foreach ($users as $user)
            $names[] = $user->username;
        return $names;
    }

}