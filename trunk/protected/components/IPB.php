<?php

class IPB {

    protected $connection;

    public function __construct() {
        /* Connect DB */
        $dsn = 'mysql:host=' . Yii::app()->params['forum']['dbHost'] . ';dbname=' . Yii::app()->params['forum']['dbName'] . '';
        $dbUser = Yii::app()->params['forum']['dbUser'];
        $dbPass = Yii::app()->params['forum']['dbPass'];
        $this->connection = new CDbConnection($dsn, $dbUser, $dbPass);
        $this->connection->active = true;
    }

    public function __destruct() {
        $this->connection->active = false;
    }

    public function login() {
        if (!Yii::app()->user->isGuest) {
            /* load forum account */
            $sql = 'SELECT * FROM `' . Yii::app()->params['forum']['dbPrefix'] . 'members` WHERE `member_id` =:member_id';
            $command = $this->connection->createCommand($sql);
            $command->bindValue(':member_id', Yii::app()->user->id);
            $member = $command->queryRow();
            if (!$member)
                return false;

            /* Set cookie */
            $this->logout();
            $cookie['member_id'] = new CHttpCookie('member_id', $member['member_id']);
            $cookie['member_id']->domain = '.' . Yii::app()->params['forum']['domain'];

            $cookie['pass_hash'] = new CHttpCookie('pass_hash', $member['member_login_key']);
            $cookie['pass_hash']->domain = '.' . Yii::app()->params['forum']['domain'];

            Yii::app()->request->cookies['member_id'] = $cookie['member_id'];
            Yii::app()->request->cookies['pass_hash'] = $cookie['pass_hash'];

            return true;
        }
        else
            return false;
    }

    public function logout() {
        /* clear cookie */
        $cookie['session_id'] = new CHttpCookie('session_id', 0);
        $cookie['session_id']->domain = '.' . Yii::app()->params['forum']['domain'];

        $cookie['member_id'] = new CHttpCookie('member_id', 0);
        $cookie['member_id']->domain = '.' . Yii::app()->params['forum']['domain'];

        $cookie['pass_hash'] = new CHttpCookie('pass_hash', 0);
        $cookie['pass_hash']->domain = '.' . Yii::app()->params['forum']['domain'];

        Yii::app()->request->cookies['member_id'] = $cookie['member_id'];
        Yii::app()->request->cookies['pass_hash'] = $cookie['pass_hash'];
        Yii::app()->request->cookies['session_id'] = $cookie['session_id'];
        return true;
    }







}
