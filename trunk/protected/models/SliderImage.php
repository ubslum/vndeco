<?php

/**
 * This is the model class for table "{{slider_images}}".
 *
 * The followings are the available columns in table '{{slider_images}}':
 * @property integer $id
 * @property string $title
 * @property string $alt
 * @property string $data_transition
 * @property integer $filedata
 * @property integer $thumb1
 * @property integer $thumb2
 * @property integer $thumb3
 */
class SliderImage extends CActiveRecord {

    public $image;
    public $tempImage;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SliderImage the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{slider_images}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('filedata', 'required'),
            array('image', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => Yii::app()->controller->action->id=='update'),
            array('title, alt, data_transition', 'length', 'max' => 256),
            array('filedata', 'checkImage', 'skipOnError' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, alt, data_transition, filedata, thumb1, thumb2, thumb3', 'safe', 'on' => 'search'),
        );
    }

    /**
     * check photo type
     */
    public function checkImage() {
        $this->tempImage = CUploadedFile::getInstance($this, 'image');
        if ($this->tempImage !== NULL) {
            if (!Common::checkImageType($this->tempImage->tempName))
                $this->addError('image', Yii::t('MCommonMessage', 'The file is not a valid image file'));
        }
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
            'id' => Yii::t('SliderImage', 'ID'),
            'title' => Yii::t('SliderImage', 'Title'),
            'alt' => Yii::t('SliderImage', 'Alt'),
            'data_transition' => Yii::t('SliderImage', 'Data Transition'),
            'filedata' => Yii::t('SliderImage', 'Filedate'),
            'thumb1' => Yii::t('SliderImage', 'Thumb1'),
            'thumb2' => Yii::t('SliderImage', 'Thumb2'),
            'thumb3' => Yii::t('SliderImage', 'Thumb3'),
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
        $criteria->compare('alt', $this->alt, true);
        $criteria->compare('data_transition', $this->data_transition, true);
        $criteria->compare('filedata', $this->filedata);
        $criteria->compare('thumb1', $this->thumb1);
        $criteria->compare('thumb2', $this->thumb2);
        $criteria->compare('thumb3', $this->thumb3);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public static function getDataTransitionList() {
        $a = array(
            'sliceDown' => 'Slice Down',
            'sliceDownLeft' => 'Slice Down Left',
            'sliceUp' => 'Slice Up',
            'sliceUpLeft' => 'Slice Up Left',
            'sliceUpDown' => 'Slice Up Down',
            'sliceUpDownLeft' => 'Slice Up Down Left',
            'fold' => 'Fold',
            'fade' => 'Fade',
            'slideInRight' => 'Slide In Right',
            'slideInLeft' => 'Slide In Left',
            'boxRandom' => 'Box Random',
            'boxRain' => 'Box Rain',
            'boxRainReverse' => 'Box Rain Reverse',
            'boxRainGrow' => 'Box Rain Grow',
            'boxRainGrowReverse' => 'Box Rain Grow Reverse'
        );
        return $a;
    }

}