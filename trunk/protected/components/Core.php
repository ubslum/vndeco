<?php

/**
 * Description of Core. Do not modify this. You must edit the Common class instead.
 * @author Gia Duy (admin@giaduy.info)
 */
class Core {

    /**
     * Get the system value
     * @param string $name Setting key
     * @return string Setting value
     */
    public static function getSetting($name) {
        $sql = 'SELECT `value` FROM {{settings}} WHERE `name`=:name';
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':name', $name);
        return $command->queryScalar();
    }

    /**
     * Generate Message Category, for saving message language. Ex: 'user.act.changeEmail' is generated when access to module User, perform action ChangeEmail in Act Controller.
     * @return string the message category string
     */
    public static function generateMessageCategory($dir, $class) {
        $messageCategory = 'CoreMessage';

        if ($class != '' && !preg_match('/Controller/', $class))
            $messageCategory = $class;


        /* if class is null and file not in modules, then set to core */
        if (preg_match('/modules[\\\\\/](\w+)\\\\/', $dir, $match))
            $messageCategory = ucfirst(strtolower($match[1])).'Message';

        return $messageCategory;
    }
    
    /**
     * Get the email message from file
     * @param string $fileName the file to read message
     * @param string $basePath the base path of $fileName, if NULL will use the app base path
     * @return string the message from file
     */
    public static function getEmailMessage($fileName, $basePath = NULL) {
        if ($basePath === NULL)
            $basePath = Yii::app()->basePath;
        $file = $basePath . DIRECTORY_SEPARATOR . 'messages' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR . Yii::app()->language . DIRECTORY_SEPARATOR . $fileName . '.php';
        if (!is_file($file))
            $file = $basePath . DIRECTORY_SEPARATOR . 'messages' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR . Yii::app()->sourceLanguage . DIRECTORY_SEPARATOR . $fileName . '.php';
        $content = file_get_contents($file);
        return $content;
    }

    /**
     * Translate certain characters
     * @param string $message
     * @param array $params
     * @return string translated message
     */
    public static function translateMessage($message, $params = array()) {
        return $params !== array() ? strtr($message, $params) : $message;
    }

    /**
     * Deep Checking Image Type, only allow GIF, JPEG, PNG
     * @param string $imgPath path to the image
     * @return boolean TRUE if the file is an image, otherwise FALSE
     */
    public static function checkImageType($imgPath) {
        if (function_exists('exif_imagetype')) {
            $type = @exif_imagetype($imgPath);
            if (!in_array($type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG)))
                return false;
        }
        return true;
    }

    /**
     * Display country list as List Data
     * @return array The contry list in array format
     */
    public static function getCountryList() {
        return CHtml::listData(Country::model()->findAll(), 'id', 'title');
    }

    /**
     * Display province list as List Data
     * @return array The province list in array format
     */
    public static function getProvinceList() {
        return CHtml::listData(Province::model()->findAll(), 'id', 'name');
    }

    /**
     * Display gendner list as List Data
     * @return array The denger list in array format
     */
    public static function getGenderList() {
        $gender = array(
            0 => Yii::t('CoreMessage', 'Male'),
            1 => Yii::t('CoreMessage', 'Female'),
        );
        return $gender;
    }

    /**
     * Get gender text
     * @return string gender
     */
    public static function getGenderText($gender) {
        if ($gender === "0")
            return Yii::t('CoreMessage', 'Male');
        if ($gender === "1")
            return Yii::t('CoreMessage', 'Female');
        return Yii::t('CoreMessage', 'Unknown');
    }

    /**
     * Display language list as List Data
     * @return array The language list in array format
     */
    public static function getLanguageList() {
        return CHtml::listData(Lang::model()->findAll(), 'id', 'title');
    }

    /**
     * Get the title of country
     * @param string $code The country code
     * @return string Country title
     */
    public static function getCountryTitle($code) {
        return Country::model()->findByPk($code)->title;
    }

    /**
     * generate a HyperLink
     * @param string $constructedURL the constructed URL
     * @return string The url begin with http://
     */
    public static function generateHyperLink($constructedURL) {
        return 'http://' . $_SERVER['HTTP_HOST'] . $constructedURL;
    }

    /**
     * get current url
     * @return string The current request url
     */
    public static function getCurrentUrl() {
        return 'http://' . $_SERVER['HTTP_HOST'] . Yii::app()->request->requestUri;
    }

    /**
     * Check if the application has error, success or notice flash message
     * @return boolean TRUE if has a flash messange, otherwise FALSE
     */
    public static function hasFlashMessages() {
        return (Yii::app()->user->hasFlash('error') || Yii::app()->user->hasFlash('success') || Yii::app()->user->hasFlash('notice'));
    }

    /**
     * Check current request is solve by module, controller and action
     * @param string $module
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public static function checkMCA($module, $controller, $action) {
        if (isset(Yii::app()->controller->module))
            return (Yii::app()->controller->module->id == $module && Yii::app()->controller->id == $controller && Yii::app()->controller->action->id == $action);
        if (isset(Yii::app()->controller->id, Yii::app()->controller->action->id))
            return (Yii::app()->controller->id == $controller && Yii::app()->controller->action->id == $action);
        return false;
    }

    /**
     * get current module, controller and action
     * @param string $module
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public static function getMCA() {
        return ucfirst(Yii::app()->controller->module ? Yii::app()->controller->module->name : '') . ucfirst(Yii::app()->controller->id) . ucfirst(Yii::app()->controller->action->id);
    }

    /**
     * generateYearDropDownDataList
     * @return list
     */
    public static function getYearDataList($begin = null, $end = null) {
        if ($end === null)
            $end = date('Y') - 16;
        if ($begin === null)
            $begin = $end - 100;
        for ($i = $begin; $i <= $end; $i++) {
            $list[$i] = $i;
        }
        return $list;
    }

    /**
     * Get Next Auto Increment
     * @param string $table
     * @return integer Increment value
     */
    public static function getNextAutoIncrement($table) {
        $sql = 'SHOW TABLE STATUS LIKE :table';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(':table', $table);
        $result = $cmd->queryRow();
        return $result['Auto_increment'];
    }

    /**
     * Format phone number
     * @param <type> $num
     * @return phone number
     */
    public static function formatPhoneNumber($num, $separator = ' ') {
        $num = preg_replace('[^0-9]', '', $num);

        $len = strlen($num);
        if ($len < 10)
            $num = preg_replace('/([0-9]+)([0-9]{3})([0-9]{4})/', '$1' . $separator . '$2' . $separator . '$3', $num);
        elseif ($len > - 10)
            $num = preg_replace('/([0-9]+)([0-9]{3})([0-9]{4})/', '$1' . $separator . '$2' . $separator . '$3', $num);

        return $num;
    }

    /**
     * Read number
     * @param string number
     */
    public static function readNumber($number, $lang = 'vi') {
        $rn = new ReadNumber();
        return $rn->docso($number);
    }

    /**
     * encode_rfc3986
     * @param string $string
     * @return string encoded
     */
    public static function encode_rfc3986($string) {
        return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode(($string))));
    }

    public static function buildQueryRaw($params) {
        $retval = '';
        foreach ((array) $params as $key => $value)
            $retval .= "{$key}={$value}&";
        $retval = substr($retval, 0, -1);
        return $retval;
    }

    /**
     * Get country name by IP
     * @param string $ip
     * @return string country name
     */
    public static function getCountryByIp($ip) {
        $url = 'http://api.hostip.info/?ip=' . $ip;
        $xml = file_get_contents($url);
        $doc = new DOMDocument();
        $doc->loadXML($xml);
        $countryName = $doc->getElementsByTagName("countryName")->item(0)->nodeValue;
        return $countryName;
    }

    /**
     * Get Yes No text
     * @param int $int
     * @return string 
     */
    public static function getYesNoText($int = null) {
        if ($int === null)
            return "N/A";
        if ($int == 0)
            return "No";
        if ($int == 1)
            return "Yes";
        return '?';
    }

    /**
     * Get Yes No List
     * @param int $int
     * @return string 
     */
    public static function getYesNoList() {
        return array('0' => 'No', '1' => 'Yes');
    }

    /**
     * Random string
     * @param int $length
     * @return string
     */
    public static function randString($length) {
        $string = sha1(rand(100000, 999999));
        return substr($string, rand(0, 32), $length);
    }

}