<?php
$this->pageTitle='Admin Control Panel - Nivo Slider';
//$this->keywords=Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), '');
//$this->description=Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), '');
//$this->setOpenGraphProtocol(array(
//    'og:title' => Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), ''),
//    'og:type' => 'website',
//    'og:image' => Common::generateHyperLink(Yii::app()->request->baseUrl . '/images/logos/logo.png'),
//    'og:url' => Common::getCurrentUrl(),
//));
//$this->setRobots('noindex, follow');
/* @var $this SliderImageController */
/* @var $model SliderImage */

$this->breadcrumbs = array(
    'ACP Home',
    'Nivo Slider',
    'Create',
);
?>

<h1><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Create Slider Image');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>