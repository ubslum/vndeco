<?php

/**
 * Main Controller of Account
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ActController extends AdminController {

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction = 'admin';
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    public function actionLogin($id)
    {
        Yii::import('application.modules.account.components.AccountIdentity');
        $account=  Account::model()->findByPk($id);
        $identity = new AccountIdentity($account->email, $account->password);
        $identity->adminAuthenticate();
        Yii::app()->user->login($identity, 0);
        $this->redirect(Yii::app()->homeUrl);
    }    
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate() {
        $model = $this->loadModel();
        if (isset($_POST['Account'])) {
            $model->attributes = $_POST['Account'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array('model' => $model));
    }

    /**
     * Change user password
     */
    public function actionChangePass() {
        $model = new ChangePasswordForm();
        $account = $this->loadModel();

        $this->performAjaxValidation($model);

        if (isset($_POST['ChangePasswordForm'])) {
            $model->attributes = $_POST['ChangePasswordForm'];
            if ($model->validate()) {
                $account->password = md5($model->newPass . $account->salt);
                if ($account->save()) {
                    Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you! The password has been changed.'));
                    $this->redirect(array('view', 'id' => $account->id));
                }
            }
        }
        else {
            if($account->type!=Account::TYPE_REGULAR) Yii::app()->user->setFlash('error', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You cannot change this user password because he/she using the third party account.'));
        }

        $this->render('changePass', array(
            'model'=>$model,
        ));

    }

    /**
     * Assign/Revoke Roles
     */
    public function actionHierarchy() {
        $model = $this->loadModel();
        $auth = Yii::app()->authManager;
        $this->render('hierarchy', array('model' => $model, 'auth' => $auth));
    }

    /**
     * Action assign
     */
    public function actionAssign() {
        $itemName = $_GET['item'];
        $id_user = $_GET['user'];
        Yii::app()->authManager->assign($itemName, $id_user);
        $this->redirect(array('hierarchy', 'id' => $id_user));
    }

    /**
     * Action revoke
     */
    public function actionRevoke() {
        $itemName = $_GET['item'];
        $id_user = $_GET['user'];
        Yii::app()->authManager->revoke($itemName, $id_user);
        $this->redirect(array('hierarchy', 'id' => $id_user));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_POST['ajax']))
                $this->redirect(array('admin'));
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * Manages all users.
     */
    public function actionAdmin() {
        $model = new Account('search');

        if (isset($_GET['Account']))
            $model->attributes = $_GET['Account'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular user.
     */
    public function actionView() {
        $model = $this->loadModel();
        $assignedRoles = array_keys(Yii::app()->authManager->getRoles($model->id));
        $roles = $assignedRoles ? $assignedRoles : array('Member');

        $this->render('view', array(
            'model' => $model,
            'roles' => $roles,
        ));
    }

    /**
     * Account Statistics
     */
    public function actionStatistics() {
        
        $statistics['totalAccount'] = Account::model()->count();
        $statistics['activated'] = Account::model()->count('status=?', array(Account::STATUS_ACTIVATED));
        $statistics['unActivated'] = Account::model()->count('status=?', array(Account::STATUS_PENDING));
        /* Registered */

        $today = mktime(0, 0, 0);
        $yesterday = mktime(0, 0, 0, date('n'), date("j") - 1);
        $last7days = mktime(0, 0, 0, date('n'), date("j") - 7);
        $last14days = mktime(0, 0, 0, date('n'), date("j") - 14);
        $thisMonth = mktime(0, 0, 0, date('n'), 1);
        $lastMonth = mktime(0, 0, 0, date('n') - 1, 1);
        $last2Month = mktime(0, 0, 0, date('n') - 2, 1);
        $last3Month = mktime(0, 0, 0, date('n') - 3, 1);
        $last6Month = mktime(0, 0, 0, date('n') - 6, 1);
        $last12Month = mktime(0, 0, 0, date('n') - 12, 1);
        $thisYear = mktime(0, 0, 0, 1, 1, date('Y'));
        $lastYear = mktime(0, 0, 0, 1, 1, date('Y') - 1);

        /* Registered today */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:today';
        $cri->params = array(':today' => $today);
        $statistics['today'] = Account::model()->count($cri);
        /* Registered yesterday */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:yesterday';
        $cri->params = array(':yesterday' => $yesterday);
        $statistics['yesterday'] = Account::model()->count($cri);
        /* Registered last7days */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:last7days';
        $cri->params = array(':last7days' => $last7days);
        $statistics['last7days'] = Account::model()->count($cri);
        /* Registered last14days */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:last14days';
        $cri->params = array(':last14days' => $last14days);
        $statistics['last14days'] = Account::model()->count($cri);
        /* Registered thisMonth */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:thisMonth';
        $cri->params = array(':thisMonth' => $thisMonth);
        $statistics['thisMonth'] = Account::model()->count($cri);
        /* Registered lastMonth */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:lastMonth';
        $cri->params = array(':lastMonth' => $lastMonth);
        $statistics['lastMonth'] = Account::model()->count($cri);
        /* Registered last2Month */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:last2Month';
        $cri->params = array(':last2Month' => $last2Month);
        $statistics['last2Month'] = Account::model()->count($cri);
        /* Registered last3Month */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:last3Month';
        $cri->params = array(':last3Month' => $last3Month);
        $statistics['last3Month'] = Account::model()->count($cri);
        /* Registered last6Month */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:last6Month';
        $cri->params = array(':last6Month' => $last6Month);
        $statistics['last6Month'] = Account::model()->count($cri);
        /* Registered last12Month */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:last12Month';
        $cri->params = array(':last12Month' => $last12Month);
        $statistics['last12Month'] = Account::model()->count($cri);
        /* Registered this year */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:thisYear';
        $cri->params = array(':thisYear' => $thisYear);
        $statistics['thisYear'] = Account::model()->count($cri);
        /* Registered last year */
        $cri = new CDbCriteria();
        $cri->condition = 'date_joined>=:lastYear';
        $cri->params = array(':lastYear' => $lastYear);
        $statistics['lastYear'] = Account::model()->count($cri);

        $this->render('statistics', array('statistics' => $statistics));
        
    }

    /**
     * view user activity
     */
    public function actionActivity()
    {
        $account = $this->loadModel();

        $this->render('activity', array(
            'model' => $model,
            'roles' => $roles,
        ));        
    }

        /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadModel($id=null) {
        if ($this->_model === null) {
            if ($id !== null || isset($_GET['id']))
                $this->_model = Account::model()->findbyPk($id !== null ? $id : $_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'The requested page does not exist.'));
        }
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'acc-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
