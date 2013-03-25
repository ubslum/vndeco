<?php
$this->pageTitle = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account');
$this->breadcrumbs = array(
        Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account'),
        Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Info'),
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'account');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account');

?>
<?php $this->widget('zii.widgets.CDetailView', array(
        //'cssFile'=>file_exists(Yii::app()->theme->basePath.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'detailview.css')?Yii::app()->theme->baseUrl.'/css/detailview.css':null,
        'data'=>$model,
        'attributes'=>array(
                array('label'=>$model->getAttributeLabel('id'), 'value'=>$model->id, 'type'=>'number'),
                'username',
                'email',
                array('label'=>$model->getAttributeLabel('date_joined'), 'type'=>'date', 'value'=>$model->date_joined),
                array('label'=>Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__),'Role(s)'), 'value'=>$roles?CHtml::listBox('roles', null, $roles, array('disabled'=>'disabled', 'style'=>'width:150px; height:50px;')):NUll, 'type'=>'raw'),
                array('label'=>$model->getAttributeLabel('status'), 'value'=>$model->status?'Active':'Inactive'),
        ),
));
?>
