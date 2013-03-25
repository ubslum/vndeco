<?php

/**
 * WTwitterNewAccount Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WTwitterNewAccount extends CWidget {
    //put your code here
    public function run() {
        parent::run();
        $model=new TwitterNewAccountForm();
        if (isset($_POST['TwitterNewAccountForm'])) {
            $model->attributes = $_POST['TwitterNewAccountForm'];
            if ($model->validate()) {
                if($model->connect()) $this->controller->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('wTwitterNewAccount', array('model'=>$model));
    }
}