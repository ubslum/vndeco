<?php
$this->pageTitle=Common::translateMessage($model->title, array('{AppName}'=>Common::getSetting('appName'),'{AppDomainName}'=>Common::getSetting('appDomainName'),'{AdminEmail}'=>Common::getSetting('adminEmail'),)).' - '.Yii::app()->name;
$this->breadcrumbs=array(
    Common::translateMessage($model->title, array('{AppName}'=>Common::getSetting('appName'),'{AppDomainName}'=>Common::getSetting('appDomainName'),'{AdminEmail}'=>Common::getSetting('adminEmail'),)),
);
$this->keywords=Common::translateMessage($model->keywords, array('{AppName}'=>Common::getSetting('appName'),'{AppDomainName}'=>Common::getSetting('appDomainName'),'{AdminEmail}'=>Common::getSetting('adminEmail'),));
$this->description=Common::translateMessage($model->description, array('{AppName}'=>Common::getSetting('appName'),'{AppDomainName}'=>Common::getSetting('appDomainName'),'{AdminEmail}'=>Common::getSetting('adminEmail'),));
//$this->setRobots('noindex, follow');
?>

<h1>
<?php
echo Common::translateMessage($model->title, array('{AppName}'=>Common::getSetting('appName'), '{AppDomainName}'=>Common::getSetting('appDomainName'), '{AdminEmail}'=>Common::getSetting('adminEmail')));
?>
</h1>
<?php
echo Common::translateMessage($model->content, array('{AppName}'=>Common::getSetting('appName'), '{AppDomainName}'=>Common::getSetting('appDomainName'), '{AdminEmail}'=>Common::getSetting('adminEmail')));
?>