<?php

class AuthItem extends CActiveRecord {
    /**
     * The followings are the available columns in table '{{auth_item}}':
     * @var string $name
     * @var integer $type
     * @var string $description
     * @var string $bizrule
     * @var string $data
     */
    const OPERATION = 0;
    const TASK = 1;
    const ROLE = 2;

    /**
     * Get AuthItem Type Options
     * @return <type>
     */
    public function getTypeOptions() {
        return array(
            self::OPERATION=>'Operation',
            self::TASK=>'Task',
            self::ROLE=>'Role',
        );
    }

    /**
     * Get AuthItem Type Text
     * @return <type>
     */
    public function getTypeText() {
        $options = $this->typeOptions;
        return isset($options[$this->type]) ? $options[$this->type]:"unknown ({$this->type})";
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
        return '{{auth_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, type', 'required'),
            array('type', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>64),
            array('description, bizrule, data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('name, type, description, bizrule, data', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'itemChild'=>array(self::HAS_MANY, 'AuthItemChild', 'parent'),
            'itemParent'=>array(self::HAS_MANY, 'AuthItemChild', 'child'),
            'userAssigned'=>array(self::HAS_MANY, 'AuthAssignment', 'itemname'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'name'          => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Name'),
            'type'          => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Type'),
            'description'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Description'),
            'bizrule'       => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Bizrule'),
            'data'          => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Data'),
        );
    }
    
    /**
     * @return array customized attribute role setting (name=>label)
     */
    public static function getRoleSettingLabels($key) {
        $labels= array(
            'max_author'        => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Maximum Allow Authors'),
            'max_resource'        => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Maximum Allow Resources'),
            'max_post_perday'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Maximum Posts per Day'),
            'max_post_permonth' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Maximum Posts per month'),
        );
        return isset($labels[$key])?$labels[$key]:$key;
    }    

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);

        $criteria->compare('type', $this->type);

        $criteria->compare('description', $this->description, true);

        $criteria->compare('bizrule', $this->bizrule, true);

        $criteria->compare('data', $this->data, true);

        return new CActiveDataProvider('AuthItem', array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>Yii::app()->params['settings']['bigPageSize'])
        ));
    }

    /**
     * Check if this item can be deleted
     * @return boolean TRUE if can be deleted, otherwise FALSE
     */
    public function canDelete() {
        if ($this->name == 'Root' || $this->name == 'Admin' || $this->name == 'Member' || $this->name == 'Guest')
            return false;
        return true;
    }

    /**
     * Validate before delete
     * @return boolean
     */
    protected function beforeDelete() {
        return $this->canDelete();
    }

    /**
     * Remove all child/parent item and AuthAssign
     */
    protected function afterDelete() {
        /* remove all child/parent */
        $criteria = new CDbCriteria;
        $criteria->condition = 'parent=:parent OR child=:child';
        $criteria->params = array(':parent'=>$this->name, ':child'=>$this->name);
        AuthItemChild::model()->deleteAll($criteria);
        /* remove all AuthAssign */
        $criteria = new CDbCriteria;
        $criteria->condition = 'itemname=:itemname';
        $criteria->params = array(':itemname'=>$this->name);
        AuthAssignment::model()->deleteAll($criteria);
    }
}