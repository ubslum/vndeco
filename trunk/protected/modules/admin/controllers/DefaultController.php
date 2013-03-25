<?php

class DefaultController extends AdminController {
    /**
     * Render the admin Home Page
     */
    public function actionIndex() {
        $this->render('index');
    }

    /**
     * Deletes all values from cache
     */
    public function actionClearCache() {
        Yii::app()->cache->flush();
        Yii::app()->user->setFlash('success', 'All values from cache deleted');
        $this->redirect('index');
    }

    /**
     * Edit Static Page
     */
    public function actionStaticPage() {
        $model=StaticPage::model()->findByPk($_GET['page']);
        if($model===null) throw new CHttpException(404,'The requested page does not exist.');

        if(isset($_POST['StaticPage'])) {
            $model->attributes=$_POST['StaticPage'];
            if($model->save()) Yii::app()->user->setFlash('success', 'The content is updated successfully.');
        }

        $this->render('staticPage', array('model'=>$model));
    }
}