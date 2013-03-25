<?php

class Log extends CActiveRecord {

    /**
     * The followings are the available columns in table '{{logs}}':
     * @var integer $id
     * @var string $level
     * @var string $category
     * @var integer $logtime
     * @var string $message
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
        return '{{logs}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('logtime', 'numerical', 'integerOnly'=>true),
            array('level, category', 'length', 'max'=>128),
            array('message', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, level, category, logtime, message', 'safe', 'on'=>'search'),
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
            'id'        => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Id'),
            'level'     => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Level'),
            'category'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Category'),
            'logtime'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Logtime'),
            'message'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Message'),
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

        $criteria->compare('level', $this->level, true);

        $criteria->compare('category', $this->category, true);

        $criteria->compare('logtime', $this->logtime);

        $criteria->compare('message', $this->message, true);

        $criteria->order='id DESC';

        return new CActiveDataProvider('Log', array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>Yii::app()->params['settings']['bigPageSize'])
        ));
    }
}