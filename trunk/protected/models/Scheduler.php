<?php

class Scheduler extends CActiveRecord {
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * The followings are the available columns in table 'wapp_scheduler':
     * @var integer $id
     * @var string $title
     * @var string $description
     * @var string $task_file
     * @var integer $last_run
     * @var integer $next_run
     * @var integer $month
     * @var integer $week_day
     * @var integer $month_day
     * @var integer $hour
     * @var integer $minute
     * @var integer $run_one
     * @var integer $enabled
     */

    /**
     * Get Status Options
     * @return <type>
     */
    public function getStatusOptions() {
        return array(
            self::STATUS_ENABLED => 'Yes',
            self::STATUS_DISABLED => 'No',
        );
    }

    /**
     * Get Status Text
     * @return <type>
     */
    public function getStatusText() {
        $options = $this->statusOptions;
        return isset($options[$this->enabled]) ? $options[$this->enabled] : "unknown ({$this->enabled})";
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
        return '{{scheduler}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('title', 'length', 'max' => 256),
            array('task_file', 'length', 'max' => 256),
            array('title, description, task_file, week_day, month, month_day, hour, minute', 'required'),
            array('week_day, month, month_day, hour, minute', 'match', 'pattern' => '/^[\d]$|^[\d]+[\d,]*[\d]+$|^[\*]$/'), // only allow xx,xx,xx and *
            array('id, last_run, next_run, run_one, enabled', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, task_file, last_run, next_run, week_day, month, month_day, hour, minute, run_one, enabled', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'logs' => array(self::HAS_MANY, 'SchedulerLog', 'id_scheduler'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('Scheduler', 'ID'),
            'title' => Yii::t('Scheduler', 'Title'),
            'description' => Yii::t('Scheduler', 'Description'),
            'task_file' => Yii::t('Scheduler', 'Task File'),
            'last_run' => Yii::t('Scheduler', 'Last Run'),
            'next_run' => Yii::t('Scheduler', 'Next Run'),
            'week_day' => Yii::t('Scheduler', 'Week Day'),
            'month' => Yii::t('Scheduler', 'Month'),
            'month_day' => Yii::t('Scheduler', 'Month Day'),
            'hour' => Yii::t('Scheduler', 'Hour'),
            'minute' => Yii::t('Scheduler', 'Minute'),
            'run_one' => Yii::t('Scheduler', 'Run one'),
            'enabled' => Yii::t('Scheduler', 'Enabled'),
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

        $criteria->compare('title', $this->title, true);

        $criteria->compare('description', $this->description, true);

        $criteria->compare('task_file', $this->task_file, true);

        $criteria->compare('last_run', $this->last_run);

        $criteria->compare('next_run', $this->next_run);

        $criteria->compare('week_day', $this->week_day, true);

        $criteria->compare('month', $this->month, true);

        $criteria->compare('month_day', $this->month_day, true);

        $criteria->compare('hour', $this->hour, true);

        $criteria->compare('minute', $this->minute, true);

        $criteria->compare('run_one', $this->run_one);

        $criteria->compare('enabled', $this->enabled);

        return new CActiveDataProvider('Scheduler', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => Yii::app()->params['settings']['bigPageSize'])
        ));
    }

    /**
     * week_day not use at this time
     * @return <type>
     */
    protected function beforeValidate() {
        $this->week_day = '*';
        return true;
    }

    /**
     * generate next run time before save
     * @return <type>
     */
    protected function beforeSave() {
        $this->next_run = $this->generateNextRun();
        return true;
    }

    /**
     * Delete scheduler logs
     * @return <type>
     */
    protected function beforeDelete() {
        foreach ($this->logs as $log)
            $log->delete();
        return true;
    }

    /**
     * Generate Next Run Time
     * @return <type>
     */
    protected function generateNextRun() {
        $now = time();

        /* Min */
        $my_minute = $this->minute;
        if ($my_minute == '*')
            $my_minute = '0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60';
        $mins = preg_split('/,/', $my_minute);
        sort($mins);

        /* Hour */
        $my_hour = $this->hour;
        if ($my_hour == '*')
            $my_hour = '0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24';
        $hours = preg_split('/,/', $my_hour);
        sort($hours);

        /* t_day_of_month */
        $my_month_day = $this->month_day;
        if ($my_month_day == '*')
            $my_month_day = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32';
        $days = preg_split('/,/', $my_month_day);
        sort($days);

        /* month */
        $my_month = $this->month;
        if ($my_month == '*')
            $my_month = '1,2,3,4,5,6,7,8,9,10,11,12,13';
        $months = preg_split('/,/', $my_month);
        sort($months);

        /* year */
        $t_year = date('Y');

        /* Generate next run */
        $minute = date('i');
        $hour = date('H');
        $day = date('d');
        $month = date('m');

        /* init */
        $i_minute=0;$i_hour=0;$i_day=0;$i_month=0;
        for ($i = 0; ($mins[$i_minute] <= $minute && $i < count($mins)); $i++) {
            $i_minute = $i;
        }
        if($mins[$i_minute]<$minute) $i_minute=0;


        for ($i = 0; ($hours[$i_hour] < $hour && $i < count($hours)); $i++) {
            $i_hour = $i;
        }
        
        if($hours[$i_hour]<$hour) $i_hour=0;
        

        for ($i = 0; ($days[$i_day] < $day && $i < count($days)); $i++) {
            $i_day = $i;
        }
        if($days[$i_day]<$day) $i_day=0;

        for ($i = 0; ($months[$i_month] < $month && $i < count($months)); $i++) {
            $i_month = $i;
        }
        if($months[$i_month]<$month) $i_month=0;
        /* init */

        $nextRun=mktime($hours[$i_hour], $mins[$i_minute], 0, $months[$i_month], $days[$i_day], $t_year);

        $i=0;
        while($nextRun<$now && $i<4)
        {
            
            if($i==0){ // hour
                if($this->hour=='*') {
                    $i_minute=0;
                    $i_hour++;
                }
            }

            if($i==1){ // day
                if($this->month_day=='*') {
                    $i_hour=0;
                    $i_day++;
                }

            }

            if($i==2){ // month
                if($this->month=='*') {
                    $i_day=0;
                    $i_month++;
                }
            }

            if($i==3) {
                $i_month=0;
                $t_year++;
            }
            //echo $months[$i_month]; echo ' i:'.$i.'<br />';
            $nextRun=mktime($hours[$i_hour], $mins[$i_minute], 0, $months[$i_month], $days[$i_day], $t_year);            
            $i++;
            
        }
        
        return $nextRun;
    }

    protected function findNextRun() {
        
    }

}