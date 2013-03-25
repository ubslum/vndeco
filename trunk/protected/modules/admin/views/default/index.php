<?php
$this->pageTitle='Admin Control Panel';
$this->breadcrumbs=array(
	'ACP Home',
);
?>

<h1>Welcome to Admin Control Panel</h1>
<p>Project: <?php echo Yii::app()->name; ?></p>
<p>Author: Gia Duy (admin@giaduy.info)</p>
<p>Powered by: Grey Neuron Group - www.greyneuron.com</p>
<p>Version: <?php echo Yii::app()->params['ver'];?></p>
<p>Release date: <?php echo date(Common::getSetting('dateFormat'), Yii::app()->params['releaseDate']);?></p>
<br />
<p>Yii Version: <?php echo Yii::getVersion();?></p>
<p>OS: <?php echo php_uname('s');?> <?php echo php_uname('r');?>
<p>PHP: <?php echo PHP_VERSION;?></p>
<p>DB driver: <?php echo Yii::app()->db->driverName;?> <?php echo Yii::app()->db->serverVersion;?></p>
<p>Copyright <?php echo date('Y');?>. All rights reserved.</p>