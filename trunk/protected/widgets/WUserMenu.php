<?php

/**
 * WUserMenu Class
 * @link http://www.greyneuron.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; greyneuron.com
 * @license http://www.greyneuron.com/code/license
 */
class WUserMenu extends CWidget {

    public function run() {
?>
<?php if(Yii::app()->user->isGuest):?>
<span><?php echo CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Login/Register'), Yii::app()->user->loginUrl, array('rel'=>'nofollow'));?></span>
<?php else:?>
<span><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Hi {USERNAME}', array('{USERNAME}'=>Yii::app()->user->name));?></span> |
<span><?php echo CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'My Account'), Yii::app()->createUrl('account/act/index'), array('rel'=>'nofollow'));?></span> | 
<span><?php echo CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Logout'), Yii::app()->createUrl('site/logout'), array('rel'=>'nofollow'));?></span>
<?php endif;?>
<?php
    }
}