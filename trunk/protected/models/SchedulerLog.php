<?php

class SchedulerLog extends CActiveRecord {

    /**
     * The followings are the available columns in table '{{scheduler_logs}}':
     * @var integer $id
     * @var integer $id_scheduler
     * @var integer $date_run
     * @var string $ip
     * @var string $description
     */
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
        return '{{scheduler_logs}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_scheduler, description', 'required'),
            array('id_scheduler, date_run', 'numerical', 'integerOnly'=>true),
            array('ip', 'length', 'max'=>16),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'ID'),
            'id_scheduler'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Scheduler'),
            'date_run'      => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Date Run'),
            'ip'            => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'IP'),
            'description'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Description'),
        );
    }
}