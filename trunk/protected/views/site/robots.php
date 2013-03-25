<?php header('Content-type: text/plain');?>
User-agent: *
Allow: /
Sitemap: <?php echo Common::generateHyperLink(Yii::app()->createUrl('site/sitemap'));?>