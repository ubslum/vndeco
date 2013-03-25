<?php

/**
 * This is the model class for table "{{emails}}".
 *
 * The followings are the available columns in table '{{emails}}':
 * @property integer $id
 * @property string $to
 * @property string $subject
 * @property string $content
 * @property integer $status
 */
class EmailQueue extends CActiveRecord {
    const STATUS_PROCESSING=0;
    const STATUS_SENT=1;

    /**
     * Get Staus Text
     * @return string text
     */
    public function getStatusText() {
        switch ($this->status) {
            case self::STATUS_PROCESSING: return Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Processing');
                break;
            case self::STATUS_SENT: return Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Sent');
                break;
            default: return Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Unknown');
                break;
        }
    }

    /**
     * Get Status Option
     * @return array status
     */
    public static function getStatusOption() {
        $option = array(
            self::STATUS_PROCESSING => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Processing'),
            self::STATUS_SENT => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Sent'),
        );
        return $option;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return EmailQueue the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{emails}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('to, subject, content, status', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('to, subject', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, to, subject, content, status', 'safe', 'on' => 'search'),
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
            'id' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'ID'),
            'to' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'To'),
            'subject' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Subject'),
            'content' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Content'),
            'time_sent'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Time Sent'),
            'status' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Status'),
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

        $criteria->compare('`to`', $this->to, true);

        $criteria->compare('subject', $this->subject, true);

        $criteria->compare('content', $this->content, true);
        
        $criteria->compare('time_sent', $this->time_sent);

        $criteria->compare('status', $this->status);

        return new CActiveDataProvider('EmailQueue', array(
            'sort' => array('defaultOrder' => array('id' => 'DESC')),
            'criteria' => $criteria,
        ));
    }

    /**
     * Send mail
     */
    public function send() {
        $email = new Email();
        $email->IsHTML(true);
        $email->AddAddress($this->to);
        $email->Subject = $this->subject. ' (#'.$this->id.')';
        $email->Body = nl2br($this->content);
        if($email->Send())
        {
            $this->status=EmailQueue::STATUS_SENT;
            $this->time_sent=time();
            $this->save();
            return true;
        }
        return false;
    }

}