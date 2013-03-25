<?php

/**
 * Main Controller of Scheduler
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ActionController extends AdminController {

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction = 'admin';
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    public function actionRun() {
        /* load task */
        $task = Scheduler::model()->findByPk($_GET['id']);
        if (!$task)
            throw new CHttpException(404, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'The requested page does not exist.'));

        $time_now = time();
        /* Update time */
        $task->last_run = $time_now;
        if ($task->run_one)
            $task->enabled = 0;
        $task->save();

        /* Include Task */
        define('SCHEDULER_TASK', '1');
        include(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'tasks' . DIRECTORY_SEPARATOR . $task->task_file . '.php');
        $task_file = new $task->task_file;

        /* Logging */
        $log = new SchedulerLog();
        $log->id_scheduler = $task->id;
        $log->date_run = $time_now;
        $log->ip = $_SERVER['REMOTE_ADDR'];
        $log->description = $task_file->run();
        $log->save();

        /* redirect to result */
        if(Yii::app()->params['schedulerDebug']===false) $this->redirect(array('taskLog', 'id' => $task->id));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'show' page.
     */
    public function actionCreate() {
        $model = new Scheduler();
        if (isset($_POST['Scheduler'])) {
            $model->attributes = $_POST['Scheduler'];
            if ($model->save())
                $this->redirect(array('admin'));
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate() {
        $model = $this->loadScheduler();
        if (isset($_POST['Scheduler'])) {
            $model->attributes = $_POST['Scheduler'];
            if ($model->save())
                $this->redirect(array('admin'));
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Scheduler('search');
        if (isset($_GET['Scheduler']))
            $model->attributes = $_GET['Scheduler'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * View Task Log
     */
    public function actionTaskLog() {
        $task = $this->loadScheduler();
        $dataProvider = new CActiveDataProvider('SchedulerLog', array(
                    'criteria' => array('condition' => 'id_scheduler=:id_scheduler', 'params' => array(':id_scheduler' => $task->id)),
                    'sort' => array('defaultOrder' => array('id' => 'DESC')),
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['settings']['bigPageSize'],
                    ),
                ));
        $this->render('taskLog', array(
            'dataProvider' => $dataProvider,
            'task' => $task
        ));
    }

    /**
     * Delete One Log
     */
    public function actionDeleteLog() {
        if (Yii::app()->request->isAjaxRequest) {
            $log = SchedulerLog::model()->findByPk($_GET['id']);
            if ($log)
                $log->delete();
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * Delete All Logs of a Task
     */
    public function actionDeleteAllLogs() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_scheduler=:id_scheduler';
            $criteria->params = array(':id_scheduler' => $this->loadScheduler()->id);
            SchedulerLog::model()->deleteAll($criteria);
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * Delete Scheduler
     */
    public function actionDelete() {
        if (Yii::app()->request->isAjaxRequest) {
            $this->loadScheduler()->delete();
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadScheduler($id=null) {
        if ($this->_model === null) {
            if ($id !== null || isset($_GET['id']))
                $this->_model = Scheduler::model()->findbyPk($id !== null ? $id : $_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'The requested page does not exist.'));
        }
        return $this->_model;
    }

}
