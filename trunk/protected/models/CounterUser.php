<?php

/**
 * This is the model class for table "{{pcounter_users}}".
 *
 * The followings are the available columns in table '{{pcounter_users}}':
 * @property string $user_ip
 * @property string $user_time
 * @property string $user_agent
 */
class CounterUser extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return CounterUser the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{pcounter_users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_ip, user_time', 'required'),
            array('user_ip', 'length', 'max' => 39),
            array('user_time', 'length', 'max' => 10),
            array('user_agent', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_ip, user_time, user_agent', 'safe', 'on' => 'search'),
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
            'user_ip' => 'User Ip',
            'user_time' => 'User Time',
            'user_agent' => 'User Agent'
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

        $criteria->compare('user_ip', $this->user_ip, true);
        $criteria->compare('user_time', $this->user_time, true);
        $criteria->compare('user_agent', $this->user_agent, true);
        
        $criteria->order='user_time DESC';

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['settings']['bigPageSize'],
            ),
        ));
    }

}