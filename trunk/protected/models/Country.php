<?php

class Country extends CActiveRecord {

    /**
     * The followings are the available columns in table '{{country}}':
     * @var string $id
     * @var string $seo_name
     * @var string $title
     * @var integer $status
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
        return '{{country}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, title, status', 'required'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('id', 'length', 'max'=>2),
            array('seo_name, title', 'length', 'max'=>50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, seo_name, title, status', 'safe', 'on'=>'search'),
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
            'id'        => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Country Code'),
            'seo_name'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Seo Name'),
            'title'     => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Title'),
            'status'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Status'),
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

        $criteria->compare('seo_name', $this->seo_name, true);

        $criteria->compare('title', $this->title, true);

        $criteria->compare('status', $this->status);

        return new CActiveDataProvider('Country', array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>Yii::app()->params['settings']['bigPageSize'])
        ));
    }
    
    protected function beforeSave() {
        $this->seo_name = SEO::SEOUrl($this->title);
        return TRUE;
    }
}