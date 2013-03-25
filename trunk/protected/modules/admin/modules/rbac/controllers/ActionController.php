<?php

/**
 * Main Controller of RBAC
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ActionController extends AdminController {

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction = 'list';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * Shows a particular model.
     */
    public function actionView() {
        $this->render('view', array('model' => $this->loadAuthItem()));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'show' page.
     */
    public function actionCreate() {
        //var_dump($_POST['data']);

        $model = new AuthItem;
        if (isset($_POST['AuthItem'])) {
            $model->attributes = $_POST['AuthItem'];

            if (isset($_POST['data']))
                $model->data = $_POST['data'];

            if ($model->validate()) {
                $authManager = Yii::app()->authManager;
                switch ($model->type) {
                    case AuthItem::ROLE:
                        $authManager->createRole($model->name, $model->description, $model->bizrule, $model->data);
                        break;
                    case AuthItem::TASK:
                        $authManager->createTask($model->name, $model->description, $model->bizrule, $model->data);
                        break;
                    case AuthItem::OPERATION:
                        $authManager->createOperation($model->name, $model->description, $model->bizrule, $model->data);
                        break;
                }
                $this->redirect(array('view', 'id' => $model->name));
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate() {
        $model = $this->loadAuthItem();
        $authItem = Yii::app()->authManager->getAuthItem($model->name);
        $model->data = $authItem->getData();

        if (isset($_POST['AuthItem'])) {
            $model->attributes = $_POST['AuthItem'];
            if ($model->validate()) {
                $authItem->setDescription($model->description);
                $authItem->setBizrule($model->bizrule);
                if (isset($_POST['data']))
                    $authItem->setData($_POST['data']);
                $this->redirect(array('view', 'id' => $model->name));
            }
        }


        $this->render('update', array('model' => $model));
    }

    /**
     * Get role setting form
     */
    public function actionRoleSetting() {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['AuthItem']['type'])) {
            if ($_POST['AuthItem']['type'] == AuthItem::ROLE)
                $this->widget('WRoleSetting', array('data' => null));
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadAuthItem()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_POST['ajax']))
                $this->redirect(array('admin'));
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * Add or Remove ChildItem of an AuthItem
     */
    public function actionHierarchy() {
        $model = $this->loadAuthItem();
        $auth = Yii::app()->authManager;
        $criteria = new CDbCriteria;
        $criteria->condition = 'type<=:type AND name<>:name';
        $criteria->params = array(':type' => $model->type, ':name' => $model->name);
        $criteria->order = 'type DESC';

        $authItems = AuthItem::model()->findAll($criteria);
        $this->render('hierarchy', array(
            'model' => $model,
            'authItems' => $authItems,
            'auth' => $auth
        ));
    }

    /**
     * Add Child Item
     */
    public function actionAddChild() {
        $parent = $_GET['parent'];
        $child = $_GET['child'];
        $auth = Yii::app()->authManager;
        $auth->addItemChild($parent, $child);
        $this->redirect(array('hierarchy', 'id' => $parent));
    }

    /**
     * Remove child item
     */
    public function actionRemoveChild() {
        $parent = $_GET['parent'];
        $child = $_GET['child'];
        $auth = Yii::app()->authManager;
        $auth->removeItemChild($parent, $child);
        $this->redirect(array('hierarchy', 'id' => $parent));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AuthItem('search');
        if (isset($_GET['AuthItem']))
            $model->attributes = $_GET['AuthItem'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadAuthItem($id = null) {
        if ($this->_model === null) {
            if ($id !== null || isset($_GET['id']))
                $this->_model = AuthItem::model()->with(array('itemChild', 'itemParent'))->findbyPk($id !== null ? $id : $_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'The requested page does not exist.'));
        }
        return $this->_model;
    }

}
