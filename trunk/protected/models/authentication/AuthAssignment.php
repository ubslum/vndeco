<?php

class AuthAssignment extends CActiveRecord {
/**
 * The followings are the available columns in table 'wapp_auth_assignment':
 * @var string $itemname
 * @var string $userid
 * @var string $bizrule
 * @var string $data
 */

/**
 * Returns the static model of the specified AR class.
 * @return CActiveRecord the static model class
 */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{auth_assignment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
        array('itemname','length','max'=>64),
        array('userid','length','max'=>64),
        array('itemname, userid', 'required'),
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
        'itemname'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Itemname'),
        'userid'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Userid'),
        'bizrule'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Bizrule'),
        'data'      => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Data'),
        );
    }
}