<?php

/**
 * This is the model class for table "{{user_logs}}".
 *
 * The followings are the available columns in table '{{user_logs}}':
 * @property integer $id
 * @property integer $id_user
 * @property string $session
 * @property string $ip
 * @property string $country
 * @property string $log
 * @property string $type
 * @property integer $object
 * @property string $url
 * @property integer $time
 */
class UserLog extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return UserLog the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_logs}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ip, session, log, time', 'required'),
            array('id_user, time', 'numerical', 'integerOnly' => true),
            array('session', 'length', 'max' => 100),
            array('log', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, id_user, ip, country, session, log, type, object, time, url', 'safe', 'on' => 'search, sessionSearch'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'account' => array(self::BELONGS_TO, 'Account', 'id_user'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'ip' => 'IP',
            'country' => 'Country',
            'id_user' => 'Account',
            'session' => 'Session',
            'log' => 'Log',
            'time' => 'Time',
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

        $criteria->select = 'DISTINCT(session), time, id_user';
        $criteria->group = 'session';
        $criteria->order='time DESC';
        
        $criteria->compare('id', $this->id);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('id_user', $this->id_user);
        $criteria->compare('session', $this->session, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('log', $this->log, true);
        $criteria->compare('time', $this->time);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['settings']['bigPageSize'],
            ),            
        ));
    }

    /**
     * Session Search
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function sessionSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition='session=:session';
        $criteria->params=array(':session'=>isset($_GET['session'])?$_GET['session']:'');
        $criteria->order='time DESC';

        $criteria->compare('id', $this->id);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('id_user', $this->id_user);
        $criteria->compare('log', $this->log, true);
        $criteria->compare('time', $this->time);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['settings']['bigPageSize'],
            ),
        ));
    }

}