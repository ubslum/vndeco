<?php

/**
 * AnswerSecretQuestionForm Class
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class AnswerSecretQuestionForm extends CFormModel {

    public $user;
    public $question;
    public $answer;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('answer', 'length', 'max'=>256),
            array('answer', 'required'),
            array('answer', 'checkAnswer'),

        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'answer'    => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your Answer'),
            'question'  => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Secret Question'),
        );
    }

    /**
     * Make sure the answer is correct
     * @param <type> $attribute
     * @param <type> $params
     */
    public function checkAnswer($attribute, $params) {
        if (strtolower(trim($this->answer)) != strtolower(trim($this->user->answer_secret_question))) $this->addError('answer', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__),'Your answer is not correct!'));
    }
}