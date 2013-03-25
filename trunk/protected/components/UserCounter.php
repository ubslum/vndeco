<?php

class UserCounter extends CComponent {

    private $time = 60;
    private $activeDuration = 900;
    private $total;
    private $online;
    private $today;
    private $max_online;
    private $max_time;
    private $refresh;

    /**
     * Konstruktor. (optional)
     * */
    public function __construct() {
        
    }

    /**
     * Diese Methode wird aus seltsamen GrÃ¼nden benÃ¶tigt oO
     * */
    public function init() {
        $this->loadData();

        /* User IP, Time */
        if ($_SERVER['REMOTE_ADDR'] != '') {
            //$user_ip = Yii::app()->db->quoteValue(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
            $user_ip = $_SERVER['REMOTE_ADDR'];
            $sql = 'INSERT INTO {{pcounter_users}} VALUES ("' . $user_ip . '", ' . time() . ', "'.$_SERVER['HTTP_USER_AGENT'].'") ON DUPLICATE KEY UPDATE user_agent="'.$_SERVER['HTTP_USER_AGENT'].'", user_time=' . time();
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
        }
        
        /* refresh */
        if ((time() - $this->refresh) > $this->time)
            $this->refresh();
        
        
    }

    public function refresh() {
        $time=time();

        /* Count and update online */
        $activeTime = $time - $this->activeDuration;
        $sql = 'SELECT count(user_ip) FROM {{pcounter_users}} WHERE user_time>:activeTime';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam('activeTime', $activeTime);
        $online = $cmd->queryScalar();

        $sql = 'UPDATE {{pcounter_save}} SET `save_value` = :online WHERE save_name="online"';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam(':online', $online);
        $cmd->execute();

        /* today */
        $todayTime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $sql = 'SELECT count(user_ip) FROM {{pcounter_users}} WHERE user_time>=:todayTime';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam('todayTime', $todayTime);
        $today = $cmd->queryScalar();

        $sql = 'UPDATE {{pcounter_save}} SET `save_value` = :today WHERE save_name="today"';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam(':today', $today);
        $cmd->execute();

        /* Max online */
        if ($this->max_online < $online) {
            $sql = 'UPDATE {{pcounter_save}} SET `save_value` = :max_online WHERE save_name="max_online";';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindParam(':max_online', $online);
            $cmd->execute();

            $sql = 'UPDATE {{pcounter_save}} SET `save_value` = :max_time WHERE save_name="max_time";';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindParam(':max_time', $time);
            $cmd->execute();
        }

        /* Total */
        $sql = 'UPDATE {{pcounter_save}} SET `save_value` = (SELECT count(user_ip) FROM {{pcounter_users}}) WHERE save_name="total";';
        $cmd = Yii::app()->db->createCommand($sql)->execute();

        /* refresh time */
        $sql = 'UPDATE {{pcounter_save}} SET `save_value` = :time WHERE save_name="refresh";';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam(':time', $time);
        $cmd->execute();
       
        /* finaly, load data*/
        $this->loadData();
    }

    /**
     * Load data info
     */
    protected function loadData() {
        $sql = 'SELECT save_name, save_value FROM {{pcounter_save}}';
        $dataReader = Yii::app()->db->createCommand($sql)->query();
        while (($row = $dataReader->read()) !== false) {
            $this->$row['save_name'] = $row['save_value'];
        }
    }

    public function getTotal() {
        return $this->total;
    }

    public function getOnline() {
        return $this->online;
    }

    public function getToday() {
        return $this->today;
    }

    public function getMaxOnline() {
        return $this->max_online;
    }

    public function getMaxTime() {
        return $this->max_time;
    }

}