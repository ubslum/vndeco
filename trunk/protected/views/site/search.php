<?php
$this->pageTitle=Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Search');
$this->breadcrumbs=array(
        Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Search'),
);
$this->keywords = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'search');
$this->description = Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Search');
$this->setRobots('noindex, follow');
?>
<div align="center">
    <div id="cse-search-results"></div>
    <script type="text/javascript">
        var googleSearchIframeName = "cse-search-results";
        var googleSearchFormName = "cse-search-box";
        var googleSearchFrameWidth = 900;
        var googleSearchDomain = "www.google.com";
        var googleSearchPath = "/cse";
    </script>
    <script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
</div>