<?php

/**
 * WBackgroundImage Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WBackgroundImage extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $day=date('N');
        $file=Yii::app()->theme->baseUrl.'/images/green-bg-'.$day.'.jpg';
        
        /* halloween event */
        $days=array(25,26,27,28,29,30,31);
        $month=array(10);
        if(in_array(date('d'), $days) && in_array(date('m'), $month))
            $file=Yii::app()->request->baseUrl.'/images/events/halloween.jpg';
        
        /* 20-11 */
        $days=array(20);
        $month=array(11);
        if(in_array(date('d'), $days) && in_array(date('m'), $month))
            $file=Yii::app()->request->baseUrl.'/images/events/20-11.jpg';
        
        /* xmas */
        $days=array(15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
        $month=array(12);
        if(in_array(date('d'), $days) && in_array(date('m'), $month))
            $file=Yii::app()->request->baseUrl.'/images/events/xmas.jpg';           
        
        /* newyear */
        $days=array(1,2,3);
        $month=array(1);
        if(in_array(date('d'), $days) && in_array(date('m'), $month))
            $file=Yii::app()->request->baseUrl.'/images/events/newyear.jpg';        
        
        /* lunar new year 2012 */
        $days=array(21,22,23,24);
        $month=array(1);
        if(in_array(date('d'), $days) && in_array(date('m'), $month)){
            $file=Yii::app()->request->baseUrl.'/images/events/2012.jpg';                
            $style="body.classic {background: url('".$file."') #9f101d no-repeat top center;}";
        }
        
        /* valentines day */
        $days=array(14);
        $month=array(2);
        if(in_array(date('d'), $days) && in_array(date('m'), $month)){
            $file=Yii::app()->request->baseUrl.'/images/events/valentines.jpg';                
        }        
        
        /* 8-3  */
        $days=array(8);
        $month=array(3);
        if(in_array(date('d'), $days) && in_array(date('m'), $month)){
            $file=Yii::app()->request->baseUrl.'/images/events/8-3.jpg';                
            $style="body.classic {background: url('".$file."') #efdfe5 no-repeat top center;}";
        }        
        
        /* css */
        if(!isset($style)) $style="body.classic {background: url('".$file."') #ecf3f9 no-repeat top center;}"; //default
        
        Yii::app()->clientScript->registerCss('body-background', $style);
    }
}