<?php

class UserLogController extends AdminController {

    /**
     * Displays log in session
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($session) {
        if(isset($_GET['layout'])) $this->layout='//layouts/blank';
        //$this->layout='//layouts/blank';
        $model = new UserLog('sessionSearch');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserLog']))
            $model->attributes = $_GET['UserLog'];

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * view all log.
     */
    public function actionAdmin() {
        $model = new UserLog('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserLog']))
            $model->attributes = $_GET['UserLog'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
