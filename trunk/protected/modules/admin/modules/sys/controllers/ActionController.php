<?php

/**
 * Main Controller of Sys
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ActionController extends AdminController {

    public $defaultAction = 'info';
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * Render PHP info
     */
    public function actionInfo() {
        $this->render('info');
    }

    /**
     * Display list of error logs
     */
    public function actionListLog() {
        $model = new Log('search');
        if (isset($_GET['Log']))
            $model->attributes = $_GET['Log'];

        $this->render('listLog', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes all error logs.
     */
    public function actionDeleteAllLogs() {
        if (Yii::app()->request->isAjaxRequest) {
            $sql = 'TRUNCATE {{logs}}';
            Yii::app()->db->createCommand($sql)->execute();
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * View Log
     */
    public function actionViewLog() {
        $this->render('viewLog', array(
            'model' => $this->loadLog(),
        ));
    }

    /**
     * Load Log
     */
    public function loadLog($id=null) {
        if ($this->_model === null) {
            if ($id !== null || isset($_GET['id']))
                $this->_model = Log::model()->findbyPk($id !== null ? $id : $_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'The requested page does not exist.'));
        }
        return $this->_model;
    }

    /**
     * Settings
     */
    public function actionSetting() {
        $this->render('setting');
    }

    /**
     * Email Queue
     */
    public function actionEmailQueue() {
        $model = new EmailQueue('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EmailQueue']))
            $model->attributes = $_GET['EmailQueue'];

        $this->render('emailQueue', array(
            'model' => $model,
        ));
    }

    /**
     * User Agents
     */
    public function actionUserAgent() {
        $model = new CounterUser('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CounterUser']))
            $model->attributes = $_GET['CounterUser'];

        $this->render('userAgent', array(
            'model' => $model,
        ));
    }

    /**
     * Delete Email
     */
    public function actionDeleteEmail() {
        if (Yii::app()->request->isAjaxRequest) {
            EmailQueue::model()->deleteByPk($_GET['id']);
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }

}
