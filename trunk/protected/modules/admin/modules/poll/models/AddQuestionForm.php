<?php
/**
 * AddQuestionForm Class
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class AddQuestionForm extends CFormModel {

    public $idPoll;
    public $question;
    public $multiple;
    public $choice0;
    public $choice1;
    public $choice2;
    public $choice3;
    public $choice4;
    public $choice5;
    public $choice6;
    public $choice7;
    public $choice8;
    public $choice9;

    public function init() {
        //parent::init();
        /* Check Poll exist */
        $exist=Poll::model()->count('id=?', array($_GET['id']));
        if($exist==0) throw new CHttpException(404,'The requested poll does not exist.');
        $this->idPoll=$_GET['id'];
    }

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('idPoll, question, choice0, choice1', 'required'),
            array('multiple, choice0, choice1, choice2, choice3, choice4, choice5, choice6, choice7, choice8, choice9', 'safe'),
            // email has to be a valid email address
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'idPoll'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'ID Poll'),
            'question'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Question'),
            'multiple'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Allow users to select multiple answers?'),

            'choice0'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 1'),
            'choice1'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 2'),
            'choice2'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 3'),
            'choice3'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 4'),
            'choice4'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 5'),
            'choice5'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 6'),
            'choice6'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 7'),
            'choice7'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 8'),
            'choice8'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 9'),
            'choice9'   => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Choice 10'),
        );
    }
}