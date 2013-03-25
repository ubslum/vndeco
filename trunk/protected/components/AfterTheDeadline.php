<?php

/**
 * AfterTheDeadline Class
 * @author Gia Duy (admin@giaduy.info)
 */
class AfterTheDeadline {

    public $key;
    public $type = 'POST';

    //put your code here
    public function __construct() {
        $this->key = Yii::app()->params['AtD']['key'];
    }

    public function checkDocument($data) {
        $url = Yii::app()->params['AtD']['url'] . '/checkDocument';
        $c = new cURL;
        $params = 'key=' . $this->key . '&data=' . $data;

        if ($this->type == 'POST')
            return $c->post($url, $params);
        if ($this->type == 'GET')
            return $c->get($url . '?' . $params);
        return false;
    }

    public function checkGrammar($data) {
        $url = Yii::app()->params['AtD']['url'] . '/checkGrammar';
        $c = new cURL;
        $params = 'key=' . $this->key . '&data=' . $data;
        
        if ($this->type == 'POST')
            return $c->post($url, $params);
        if ($this->type == 'GET')
            return $c->get($url . '?' . $params);
        return false;
    }

    public function stats($data) {
        $url = Yii::app()->params['AtD']['url'] . '/stats';
        $c = new cURL;
        $params = 'key=' . $this->key . '&data=' . $data;

        if ($this->type == 'POST')
            return $c->post($url, $params);
        if ($this->type == 'GET')
            return $c->get($url . '?' . $params);
        return false;
    }

    public function xml2array($xml) {
        $xmlObj = @simplexml_load_string($xml);
        if($xmlObj!==false){
        $arrXml = $this->objectsIntoArray($xmlObj);
        return $arrXml;
        }
        return false;
    }

    public function objectsIntoArray($arrObjData, $arrSkipIndices = array()) {
        $arrData = array();

        // if input is object, convert into array
        if (is_object($arrObjData)) {
            $arrObjData = get_object_vars($arrObjData);
        }

        if (is_array($arrObjData)) {
            foreach ($arrObjData as $index => $value) {
                if (is_object($value) || is_array($value)) {
                    $value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
                }
                if (in_array($index, $arrSkipIndices)) {
                    continue;
                }
                $arrData[$index] = $value;
            }
        }
        return $arrData;
    }

}