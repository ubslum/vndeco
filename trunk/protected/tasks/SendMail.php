<?php

/**
 * SendMail Class
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class SendMail {

    public function run() {
        set_time_limit(0);
        $result=$this->sendMailQueue();
        return $result;
    }

    protected function sendMailQueue() {
        $cri = new CDbCriteria();
        $cri->condition = 'status=:status';
        $cri->params=array(':status'=>  EmailQueue::STATUS_PROCESSING);
        $cri->order = 'id';
        $cri->limit = 1;
        $mails = EmailQueue::model()->findAll($cri);

        if ($mails) {
            $result = '';
            foreach ($mails as $mail) {
                $mail->send();
                /* result */
                $result.='Email ID ' . $mail->id . ' has been sent.<br />';
            }
            return $result;
        }
        return 'No more email need to be sent!';
    }
}
