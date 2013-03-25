<?php

/**
 * WTwitterConnect Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WTwitterConnect extends CWidget {
    //put your code here
    public function run() {
        parent::run();
        $model=new TwitterConnectForm();
        if (isset($_POST['TwitterConnectForm'])) {
            $model->attributes = $_POST['TwitterConnectForm'];
            if ($model->validate()) {
                if($model->connect()) $this->controller->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('wTwitterConnect', array('model'=>$model));
    }
}