<?php

/**
 * MyPhpMessageSource
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class MyPhpMessageSource {
    /**
     * Check Missing Translation
     */
    public static function checkMissingTranslation($e) {
        
        //var_dump($e);
        $file=$e->sender->basePath.DIRECTORY_SEPARATOR.$e->language.DIRECTORY_SEPARATOR.$e->category.'.php';
        if(!is_file($file)) self::createFile($file, $e);
        else self::addTranslation($file, $e);
        $e->message='#'.$e->message.'#';
    }

    /**
     * Create new message file
     * @param <type> $e
     */
    public static function createFile($file, $e)
    {
        $content="<?php

return array(
    '".$e->message."' => '#".$e->message."#',
);
";
        file_put_contents($file, $content);
    }

    /**
     * Create new message file
     * @param <type> $e
     */
    public static function addTranslation($file, $e)
    {
        /* load file */
        $array=  require $file;
        $array[$e->message]='#'.$e->message.'#';

        ksort($array);
        
        $keys=array_keys($array);

        $content="<?php

return array(
";
        foreach($keys as $key)
        {
            $content.="    '".$key."' => '".$array[$key]."',
";
        }
        $content.=");";
        file_put_contents($file, $content);
    }
}
