<?php

class AuthItemChild extends CActiveRecord {

    /**
     * The followings are the available columns in table 'wapp_auth_item_child':
     * @var string $parent
     * @var string $child
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
        return '{{auth_item_child}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('parent', 'length', 'max'=>64),
            array('child', 'length', 'max'=>64),
            array('parent, child', 'required'),
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
            'parent'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Parent'),
            'child'     => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Child'),
        );
    }
}