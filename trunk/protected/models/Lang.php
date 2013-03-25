<?php

class Lang extends CActiveRecord {

    /**
     * The followings are the available columns in table '{{lang}}':
     * @var string $id
     * @var string $title
     * @var integer $default_lang
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
        return '{{lang}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, title', 'required'),
            array('default_lang', 'numerical', 'integerOnly'=>true),
            array('id', 'length', 'max'=>20),
            array('title', 'length', 'max'=>50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, default_lang', 'safe', 'on'=>'search'),
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
            'id'            => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Locale'),
            'title'         => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Title'),
            'default_lang'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Default'),
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

        $criteria->compare('id', $this->id, true);

        $criteria->compare('title', $this->title, true);

        $criteria->compare('default_lang', $this->default_lang);

        return new CActiveDataProvider('Lang', array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>Yii::app()->params['settings']['bigPageSize'])
        ));
    }

    /**
     * If this is new default language, make all others not default.
     */
    protected function beforeSave() {
        /* if the new lang is default then set all other to 0 */
        if ($this->default_lang) {
            $sql = 'UPDATE {{lang}} SET default_lang = 0';
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
        }
        return true;
    }


    /**
     * Check if this language can be deleted
     * @return boolean TRUE if can be deleted, otherwise FALSE
     */
    public function canDelete() {
        if (($this->default_lang) or ($this->id == Yii::app()->sourceLanguage)) return false;
        return true;
    }

    /**
     * Not to delete default language
     * @return <type>
     */
    protected function beforeDelete() {
        return $this->canDelete();
    }


}