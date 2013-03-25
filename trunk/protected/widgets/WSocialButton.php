<?php

/**
 * WSocialButton class file
 * @author Harry Tang (admin@justshowof.com)
 * @link http://www.justshowof.com/
 */
class WSocialButton extends CWidget {

    public $type = 'horizontal';
    public $style = 'box';
    public $align = 'center';
    public $url;

    public function init() {
        parent::init();
        Yii::app()->clientScript->registerScriptFile('https://apis.google.com/js/plusone.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile('http://platform.twitter.com/widgets.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile('http://connect.facebook.net/en_US/all.js#appId=220227991326675&xfbml=1', CClientScript::POS_END);
    }

    public function run() {
        echo '<div class="clearfix" align="'.$this->align.'">';
        if ($this->type == 'horizontal')
            $this->horizontal();
        if ($this->type == 'vertical')
            $this->vertical();
        echo '</div>';
    }

    public function vertical() {
        ?>
            <?php if($this->style=='standard'):?>
            <table style="width: auto;">
                <tr><td><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" <?php echo $this->url!=''?'data-url="'.$this->url.'"':'';?>>Tweet</a></td></tr>
                <tr><td><g:plusone size="medium" <?php echo $this->url!=''?'href="'.$this->url.'"':'';?>></g:plusone></td></tr>            
                <tr><td><div id="fb-root"></div><fb:like <?php echo $this->url!=''?'href="'.$this->url.'"':'';?> send="false" layout="button_count" width="" show_faces="true" font=""></fb:like></td></tr>
            </table>
            <?php endif;?>

            <?php if($this->style=='box'):?>
            <table style="width: auto;">
                <tr><td><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical" <?php echo $this->url!=''?'data-url="'.$this->url.'"':'';?>>Tweet</a></td></tr>
                <tr><td><g:plusone size="tall" <?php echo $this->url!=''?'href="'.$this->url.'"':'';?>></g:plusone></td></tr>            
                <tr><td><div id="fb-root"></div><fb:like <?php echo $this->url!=''?'href="'.$this->url.'"':'';?> send="false" layout="box_count" width="" show_faces="true" font=""></fb:like></td></tr>
            </table>
            <?php endif;?>

        <?php
    }

    public function horizontal() {
        ?>
            <?php if($this->style=='standard'):?>
            <table style="width: auto;">
                <tr>                
                    <td><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" <?php echo $this->url!=''?'data-url="'.$this->url.'"':'';?>>Tweet</a></td>
                    <td><g:plusone size="medium" <?php echo $this->url!=''?'href="'.$this->url.'"':'';?>></g:plusone></td>                
                    <td><div id="fb-root"></div><fb:like <?php echo $this->url!=''?'href="'.$this->url.'"':'';?> send="false" layout="button_count" width="" show_faces="true" font=""></fb:like></td>
                </tr>
            </table>
            <?php endif;?>

            <?php if($this->style=='box'):?>
            <table style="width: auto;">
                <tr>                
                    <td><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical" <?php echo $this->url!=''?'data-url="'.$this->url.'"':'';?>>Tweet</a></td>
                    <td><g:plusone size="tall" <?php echo $this->url!=''?'href="'.$this->url.'"':'';?>></g:plusone></td>                
                    <td><div id="fb-root"></div><fb:like <?php echo $this->url!=''?'href="'.$this->url.'"':'';?> send="false" layout="box_count" width="" show_faces="true" font=""></fb:like></td>
                </tr>
            </table>
            <?php endif;?>

        <?php
    }
}