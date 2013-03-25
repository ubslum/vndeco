<?php

class SliderImageController extends AdminController {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';
    
    public $defaultAction='admin';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'roles' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }



    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SliderImage;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);

        if (isset($_POST['SliderImage'])) {
            $model->attributes = $_POST['SliderImage'];
            if ($model->validate()) {
                /* save customer image */
                if ($model->tempImage) {
                    /* small thumb */
                    $thumb1name = tempnam(sys_get_temp_dir(), 'wv_');
                    $thumb = ImageThumb::create($model->tempImage->tempName);
                    $thumb->adaptiveResize(Yii::app()->params['sliderImage']['smallThumbWidth'], Yii::app()->params['sliderImage']['smallThumbHeight']);
                    $thumb->save(realpath($thumb1name), 'jpg');
                    /* medium  thumb */
                    $thumb2name = tempnam(sys_get_temp_dir(), 'wv_');
                    $thumb = ImageThumb::create($model->tempImage->tempName);
                    $thumb->adaptiveResize(Yii::app()->params['sliderImage']['mediumThumbWidth'], Yii::app()->params['sliderImage']['mediumThumbHeight']);
                    $thumb->save(realpath($thumb2name), 'jpg');
                    /* big  thumb */
                    $thumb3name = tempnam(sys_get_temp_dir(), 'wv_');
                    $thumb = ImageThumb::create($model->tempImage->tempName);
                    $thumb->adaptiveResize(Yii::app()->params['sliderImage']['bigThumbWidth'], Yii::app()->params['sliderImage']['bigThumbHeight']);
                    $thumb->save(realpath($thumb3name), 'jpg');
                    /* org */
                    $image = ImageThumb::create($model->tempImage->tempName);
                    $image->adaptiveResize(Yii::app()->params['sliderImage']['photoWidth'], Yii::app()->params['sliderImage']['photoHeight']);
                    $image->save($model->tempImage->tempName, 'jpg');
                    $model->filedata = @file_get_contents($model->tempImage->tempName);
                    $model->thumb1 = @file_get_contents($thumb1name);
                    $model->thumb2 = @file_get_contents($thumb2name);
                    $model->thumb3 = @file_get_contents($thumb3name);
                }
                if ($model->save()) {
                    //echo $model->tempImage->tempName;
                    $this->redirect(array('admin'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);

        if (isset($_POST['SliderImage'])) {
            $model->attributes = $_POST['SliderImage'];
            if ($model->validate()) {
                /* save customer image */
                if ($model->tempImage) {
                    /* small thumb */
                    $thumb1name = tempnam(sys_get_temp_dir(), 'wv_');
                    $thumb = ImageThumb::create($model->tempImage->tempName);
                    $thumb->adaptiveResize(Yii::app()->params['sliderImage']['smallThumbWidth'], Yii::app()->params['sliderImage']['smallThumbHeight']);
                    $thumb->save(realpath($thumb1name), 'jpg');
                    /* medium  thumb */
                    $thumb2name = tempnam(sys_get_temp_dir(), 'wv_');
                    $thumb = ImageThumb::create($model->tempImage->tempName);
                    $thumb->adaptiveResize(Yii::app()->params['sliderImage']['mediumThumbWidth'], Yii::app()->params['sliderImage']['mediumThumbHeight']);
                    $thumb->save(realpath($thumb2name), 'jpg');
                    /* big  thumb */
                    $thumb3name = tempnam(sys_get_temp_dir(), 'wv_');
                    $thumb = ImageThumb::create($model->tempImage->tempName);
                    $thumb->adaptiveResize(Yii::app()->params['sliderImage']['bigThumbWidth'], Yii::app()->params['sliderImage']['bigThumbHeight']);
                    $thumb->save(realpath($thumb3name), 'jpg');
                    /* org */
                    $image = ImageThumb::create($model->tempImage->tempName);
                    $image->adaptiveResize(Yii::app()->params['sliderImage']['photoWidth'], Yii::app()->params['sliderImage']['photoHeight']);
                    $image->save($model->tempImage->tempName, 'jpg');
                    $model->filedata = @file_get_contents($model->tempImage->tempName);
                    $model->thumb1 = @file_get_contents($thumb1name);
                    $model->thumb2 = @file_get_contents($thumb2name);
                    $model->thumb3 = @file_get_contents($thumb3name);
                }
                if ($model->save()) {
                    //echo $model->tempImage->tempName;
                    $this->redirect(array('admin'));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SliderImage('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SliderImage']))
            $model->attributes = $_GET['SliderImage'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SliderImage::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t(Common::generateMessageCategory(null, 'CoreMessage'), 'The requested page does not exist.'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'slider-image-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
