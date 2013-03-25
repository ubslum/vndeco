<?php
/**
 * PAccountMenu
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
Yii::import('zii.widgets.CPortlet');
class PAccountMenu extends CPortlet {
/**
 * Init
 */
    public function  init() {
        $this->title = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account CPanel');
        parent::init();
    }

    /**
     * Menu
     */
    public function getItems() {
        if(!Yii::app()->user->isGuest)
            return array(
            array('label'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account Info'), 'url'=>Yii::app()->createUrl('account/act/index'), 'active'=>Yii::app()->controller->action->id == 'index'),
            //array('label'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Set Username'), 'url'=>Yii::app()->createUrl('account/act/setUsername'), 'active'=>Yii::app()->controller->action->id == 'setUsername'),            
            array('label'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Change Email'), 'url'=>Yii::app()->createUrl('account/act/changeEmail'), 'active'=>Yii::app()->controller->action->id == 'changeEmail'),
            array('label'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Manage Password'), 'url'=>Yii::app()->createUrl('account/act/changePassword'), 'active'=>(Yii::app()->controller->action->id == 'changePassword' || Yii::app()->controller->action->id == 'setPassword')),
            array('label'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Linked Accounts'), 'url'=>Yii::app()->createUrl('account/act/linkedAccount'), 'active'=>Yii::app()->controller->action->id == 'linkedAccount'),
            );
        else
            return array(
            array('label'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Create Account'), 'url'=>Yii::app()->createUrl('account/act/create'), 'active'=>Yii::app()->controller->action->id == 'create'),
            array('label'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Forgot Password?'), 'url'=>Yii::app()->createUrl('account/act/forgotPassword'), 'active'=>Yii::app()->controller->action->id == 'forgotPassword'),
            array('label'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Re-send Activate Email'), 'url'=>Yii::app()->createUrl('account/act/resendActivateEmail'), 'active'=>Yii::app()->controller->action->id == 'resendActivateEmail'),
            );
    }

    /**
     * Render Content
     */
    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items'=>$this->items,
            'activateParents'=>true,
            'htmlOptions'=>array('class'=>'operations'),
        ));
    }

}




