<?php

/**
 * ChangePhotoForm
 * @author Gia Duy (admin@giaduy.info)
 */
class ChangePhotoForm extends CFormModel {

    public $photo, $tempImage;
    

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            //array('photo', 'required'),
            array('photo', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>false),
            array('photo', 'checkImage', 'skipOnError'=>true),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'photo'      => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Photo'),
        );
    }

    /**
     * Check Photo
     */
    public function checkImage($attribute, $params) {
        $this->tempImage=CUploadedFile::getInstance($this,'photo');
        if($this->tempImage!==NULL) {
            if(!Common::checkImageType($this->tempImage->tempName)) $this->addError('image', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__),'The file is not a valid image file.'));
        }        
    }
}