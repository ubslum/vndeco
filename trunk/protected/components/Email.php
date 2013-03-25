<?php
require_once(Yii::app()->basePath.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'3rdparty'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'class.phpmailer.php');
/**
 * Email Class
 * @author Gia Duy
 * @example
 * <pre>
 * $email=new Email;
 * $email->AddAddress('admin@giaduy.info'); // Sent to
 * $email->Subject = 'Welcome';
 * $email->Body    = 'This is your messabe'
 * $email->AddReplyTo('admin@giaduy.info', 'Gia Duy Duong');
 * $email->Send();
 * </pre>
 */
class Email extends PHPMailer {
/**
 * Email Class
 * @author Gia Duy
 * @example
 * <pre>
 * $email=new Email;
 * $email->AddAddress('admin@giaduy.info'); // Sent to
 * $email->Subject = 'Welcome';
 * $email->Body    = 'This is your messabe'
 * $email->AddReplyTo('admin@giaduy.info', 'Gia Duy Duong');
 * $email->Send();
 * </pre>
 */
    public function __construct() {
        parent::__construct();

        $this->Mailer       = Common::getSetting('mailer');

        $this->SMTPSecure   = Common::getSetting('smtpSecure');                 // sets the prefix to the servier
        $this->Host         = Common::getSetting('smtpHost');      // sets GMAIL as the SMTP server
        $this->Port         = Common::getSetting('smtpPort');                   // set the SMTP port
        $this->Username     = Common::getSetting('smtpUser');  // GMAIL username
        $this->Password     = Common::getSetting('smtpPass');            // GMAIL password
        $this->CharSet      = 'utf-8';

        $this->init();
    }

    /**
     * Init function
     */
    public function init() {
        $this->SMTPAuth     = ($this->Username!='' && $this->Password!='')?TRUE:FALSE;
        $this->From         = Common::getSetting('noreplyEmail');
        $this->FromName     = Yii::app()->name;
    }

}