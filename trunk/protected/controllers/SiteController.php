<?php

class SiteController extends MyController {

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        if (!isset($_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_ADDR'])) {
            echo 'PHP Command Line';
            return;
        } else if (($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']) && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
            echo 'PHP Command Line'; // PHP Command line
            return;
        }

        $this->render('index');
    }

    /**
     * This is page where google search result displayed
     */
    public function actionSearch() {
        $this->layout = 'column1';
        $this->render('search');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = 'error';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;

        if (!Yii::app()->user->isGuest) {
            $model->name = Yii::app()->user->name;
            $model->email = Account::model()->findByPk(Yii::app()->user->id)->email;
        }

        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $content = Common::getEmailMessage('contactForm');
                $content.=Common::getSetting('emailFooter');

                $email = new Email();
                $email->AddAddress(Common::getSetting('adminEmail'));
                $email->AddReplyTo($model->email);
                //$email->AddReplyTo(Common::getSetting('adminEmail'));
                $email->Subject = $model->subject;
                $email->Body = Common::translateMessage($content, array('{sender}' => $model->name, '{content}' => $model->body));
                if ($email->Send()) {
                    Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Thank you for contacting us. We will respond to you as soon as possible.'));
                    $this->refresh();
                }
                else
                    Yii::app()->user->setFlash('error', Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'An error occured while sending mail: {ERROR}', array('{ERROR}'=>$email->ErrorInfo)));
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Display static content
     */
    public function actionPage() {
        $this->layout = 'column1';
        $model = StaticPage::model()->findByPk($_GET['view']);
        if ($model === null)
            throw new CHttpException(404, Yii::t('CoreMessage','The requested page does not exist.'));
        $this->render('page', array('model' => $model));
    }

    /**
     * Sitemap.xml
     */
    public function actionSitemap() {
        $this->renderPartial('sitemap');
    }

    /**
     * Robots.txt
     */
    public function actionRobots() {
        $this->renderPartial('robots');
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Performs the AJAX validation. 
     * @param CModel the model to be validated 
     */
    public function actionPerformAjaxValidation($model, $form) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form) {
            $model=new $model;
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionTest() {
        return;
    }

}