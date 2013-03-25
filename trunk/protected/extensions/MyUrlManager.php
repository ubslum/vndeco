<?php
/**
 * MyUrlManager
 */
class MyUrlManager extends CUrlManager{

    /**
     * Add param lang=xx to every URL
     * @param <type> $route
     * @param <type> $params
     * @param <type> $ampersand
     * @return <type>
     */
    public function createUrl($route, $params=array(), $ampersand='&'){
        if(Yii::app()->params['langSystem']){
            if(!isset($params['lang']) && !Common::checkMCA('', 'site', 'robots') && !Common::checkMCA('', 'site', 'sitemap')) $params['lang']=Yii::app()->language;
        }
        return parent::createUrl($route,$params,$ampersand);
    }   
}
