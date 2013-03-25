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
    'Manage',
);
?>

<h1><?php echo Yii::t(Common::generateMessageCategory(__FILE__, __CLASS__), 'Manage Slider Images'); ?></h1>

<p>
    <?php echo Yii::t(Common::generateMessageCategory(null, 'CoreMessage'), 'You may optionally enter a comparison operator'); ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    <?php echo Yii::t(Common::generateMessageCategory(null, 'CoreMessage'), 'or'); ?> <b>=</b>) <?php echo Yii::t(Common::generateMessageCategory(null, 'CoreMessage'), 'at the beginning of each of your search values to specify how the comparison should be done.'); ?></p>


<?php
$this->widget('application.plugins.lightbox.Lightbox');
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'slider-image-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array('name'=>'image', 'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl . "/image.php?type=sliderThumb&size=big&id=" . $data->id, "Image"), Yii::app()->request->baseUrl . "/image.php?type=sliderImage&id=" . $data->id, array("rel" => "lightbox"))', 'type'=>'raw', 'filter'=>false),
        'title',
        'alt',
        array('name'=>'data_transition', 'value'=>'$data->data_transition', 'filter'=>  SliderImage::getDataTransitionList()),
        array(
            'class' => 'CButtonColumn',
            'template'=>'{update}{delete}'
        ),
    ),
));
?>
