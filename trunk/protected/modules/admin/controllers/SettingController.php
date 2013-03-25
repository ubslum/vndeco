<?php

class SettingController extends AdminController {

    /**
     * Save setting
     */
    public function actionUpdateSetting() {
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['name'], $_POST['value'])) {
                $sql='UPDATE {{settings}} SET `value` = :value WHERE `name` = :name';
                $commd=Yii::app()->db->createCommand($sql);
                $commd->bindValue(':value', $_POST['value']);
                $commd->bindValue(':name', $_POST['name']);
                $commd->execute();
            }
        }
        else throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Sort Settings
     */
    public function actionSortSetting() {
        if(Yii::app()->request->isAjaxRequest) {

            $ordered=$_GET['setting'];
            foreach ($ordered as $order => $item) :
                $sql='UPDATE {{settings}} SET `order` = :order WHERE `name` = :name';
                $commd=Yii::app()->db->createCommand($sql);
                $commd->bindValue(':order', $order);
                $commd->bindValue(':name', $item);
                $commd->execute();
            endforeach;
        }
        else throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }
}