<?php

/**
 * WBrowserDetection
 * @author Gia Duy (admin@giaduy.info)
 */
class WBrowserDetection extends CWidget {

    public function run() {
        $bd = new BrowserDetection();
        $b = $bd->getBrowser();
        $v = $bd->getVersion();

        if ($b == BrowserDetection::BROWSER_IE && $v < 7)
            $this->displayWarning();
    }

    public function displayWarning() {
        $this->registerCss();
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'mydialog',
            'theme' => 'jqueryui',
            'themeUrl' => Yii::app()->theme->baseUrl,
            'cssFile' => 'jquery-ui.custom.css',
            'options' => array(
                'title' => Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your browser is outdated!'),
                'autoOpen' => true,
                'modal' => true,
                'resizable' => false,
                'draggable' => false,
                'width' => 475,
                'height' => 300,
                'closeOnEscape' => false,
            ),
        ));
        ?>
        <div class="flash-error"><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Warning: Your browser is too old to handle this website.'); ?></div>
        <div><strong><?php echo Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Please upgrade to a modern browser:'); ?></strong></div>
        <div class="clearfix"><br /></div>
        <ul id="links">
            <li id="link-chrome"><a title="Download Chrome" href="http://www.google.com/chrome"><span>Google<br /><strong>Chrome</strong></span></a></li>
            <li id="link-firefox"><a title="Download Firefox" href="http://www.mozilla.com"><span>Mozilla<br /><strong>Firefox</strong></span></a></li>
            <li id="link-safari"><a title="Download Safari" href="http://www.apple.com/safari/"><span>Apple<br/ ><strong>Safari</strong></span></a></li>
            <li id="link-ie"><a title="Download Internet Explorer" href="http://www.microsoft.com/windows/internet-explorer/default.aspx"><span>Microsoft<br /><strong>Internet<br />Explorer</strong></span></a></li>
            <li id="link-opera"><a title="Download Opera" href="http://www.opera.com"><span><br /><strong>Opera</strong></span></a></li>
        </ul>
        <?php
        $this->endWidget('zii.widgets.jui.CJuiDialog');
    }

    protected function registerCss() {
        $css = '
            #links {
                list-style-type: none;
            }
            #links li {width: 110px; float: left; margin: 10px 5px;}
            
            #links li#link-chrome a {
                background-image: url("' . Yii::app()->request->baseUrl . '/images/browsers/chrome.jpg");
            }
            #links li#link-firefox a {
                background-image: url("' . Yii::app()->request->baseUrl . '/images/browsers/firefox.jpg");
            }
            #links li#link-safari a {
                background-image: url("' . Yii::app()->request->baseUrl . '/images/browsers/safari.jpg");
            }
            #links li#link-ie a {
                background-image: url("' . Yii::app()->request->baseUrl . '/images/browsers/ie.jpg");
            }
            #links li#link-opera a {
                background-image: url("' . Yii::app()->request->baseUrl . '/images/browsers/opera.png");
            }            
            #links li a {
                background-repeat: no-repeat;
                color: #666666;
                display: block;
                font-size: 10px;
                height: 50px;
                line-height: 12px;
                padding-left: 54px;
                padding-top: 5px;
            }            
';
        Yii::app()->clientScript->registerCss('WBrowserDetection', $css);
    }

}