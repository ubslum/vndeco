<?php

/**
 * WTopMenu Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WTopMenu extends CWidget {

    public function run() {
        $langs = Common::getLanguageList();
        foreach ($langs as $key => $lang) {
            $params = array('lang' => $key);
            $params = array_merge($_GET, $params);
            $items[] = array('label' => $lang, 'active'=>$key==Yii::app()->language, 'linkOptions'=>array('rel'=>'nofollow'), 'url' => Yii::app()->controller->createUrl(Yii::app()->controller->action->id, $params));
        }
        $this->render('wTopMenu', array('items' => $items));
    }

}