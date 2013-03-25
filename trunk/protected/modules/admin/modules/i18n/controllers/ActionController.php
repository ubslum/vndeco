<?php
/**
 * Main Controller of I18N
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class ActionController extends AdminController {

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction='admin';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;




    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'show' page.
     */
    public function actionCreate() {
        $model=new Lang;
        if(isset($_POST['Lang'])) {
            $model->attributes=$_POST['Lang'];
            if($model->save()) {
                /* Redirect */
                $this->redirect(array('admin'));
            }

        }
        $this->render('create',array('model'=>$model));
    }

    /**
     * Get all Locales ID
     * @return <type>
     */
    protected function getLocaleIDs() {
        $localeIDs=Yii::app()->locale->getLocaleIDs();
        foreach($localeIDs as $locale) {
            $locales[$locale]=$locale;
        }
        return $locales;

    }



    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate() {
        $model=$this->loadModel();
        if(isset($_POST['Lang'])) {
            $model->attributes=$_POST['Lang'];
            if($model->save())
                $this->redirect(array('admin'));
        }
        $this->render('update',array('model'=>$model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete() {
        if(Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel()->delete();
            
            // if AJAX request and no flash message (triggered by deletion via admin grid view), we should not redirect the browser
            if(isset($_POST['ajax']))
                $this->redirect(array('admin'));
        }
        else throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }


    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model=new Lang('search');
        if(isset($_GET['Lang']))
            $model->attributes=$_GET['Lang'];

        $this->render('admin',array(
                'model'=>$model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel() {
        if($this->_model===null) {
            if(isset($_GET['id']))
                $this->_model=Lang::model()->findbyPk($_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'The requested page does not exist.'));
        }
        return $this->_model;
    }


}
