<?php

/**
 * ContentHandler Class
 * @link http://www.greyneuron.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; greyneuron.com
 * @license http://www.greyneuron.com/code/license
 */
class ContentHandler {

    /**
     * Remove non alphanumeric characters
     * @param string $string
     * @return string alphanumeric characters
     */
    public static function removeNonAlnum($string) {
        $patterns[0] = '/[^A-Za-z0-9 ]/';
        $replacements[0] = '';
        return preg_replace($patterns, $replacements, $string);
    }

    /**
     * Remove non utf alphanumeric characters
     * @param string $string
     * @return string alphanumeric characters
     */
    public static function removeNonUtfAlnum($string) {
        $patterns[0] = '/[^A-Za-z0-9 àáảãạÀÁẢÃẠăằắẳẵặĂẰẮẲẴẶâầấẩẫậÂẦẤẨẪẬđĐèéẻẽẹÈÉẺẼẸêềếểễệÊỀẾỂỄỆìíỉĩịÌÍỈĨỊòóỏõọÒÓỎÕỌôồốổỗộÔỒỐỔỖỘơờớởỡợƠỜỚỞỠỢùúủũụÙÚỦŨỤưừứửữựƯỪỨỬỮỰỳýỷỹỵỲÝỶỸỴ]/';
        $replacements[0] = '';

        $punctuations = array('“', '”', ',', ')', '(', '.', "'", '"', '<', '>', '!', '?', '/', '-', '.', '_', '[', ']', ':', '+', '=', '#', '$', '&quot;', '&copy;', '&gt;', '&lt;', '&nbsp;', '&trade;', '&reg;', ';', chr(10), chr(13), chr(9));
        $string = str_replace($punctuations, ' ', $string);

        return preg_replace($patterns, $replacements, $string);
    }

    /**
     * Strip whitespace from the beginning, center and end of a string
     * @param string $string
     * @return string
     */
    public static function reduceWhitespace($string) {
        return trim(preg_replace('/[ \t]+/', ' ', $string));
    }

    /**
     * Remove content style
     * @param string $content the content witch have style want to remove
     * @param array $except the except style allow
     * @return string style
     */
    public static function remove_style($content, $except=array('font-style', 'font-weight', 'text-align')) {
        $allow = implode($except, '|');
        $regexp = '@([^;"]+)?(?<!' . $allow . '):(?!\/\/(.+?)\/)((.*?)[^;"]+)(;)?@is';
        $newContent = preg_replace($regexp, '', $content);
        $newContent = preg_replace('@[a-z]*=""@is', '', $newContent); // remove any unwanted style attributes
        return $newContent;
    }

    /**
     * String tags and attributes
     * @param <type> $string
     * @param <type> $allowtags
     * @param <type> $allowattributes
     * @return <type>
     */
    public static function strip_tags_attributes($string, $allowtags=NULL, $allowattributes='no_allow_any_attributes') {
        $string = strip_tags($string, $allowtags);
        if (!is_null($allowattributes)) {
            if (!is_array($allowattributes))
                $allowattributes = explode(",", $allowattributes);
            if (is_array($allowattributes))
                $allowattributes = implode(")(?<!", $allowattributes);
            if (strlen($allowattributes) > 0)
                $allowattributes = "(?<!" . $allowattributes . ")";
            $string = preg_replace_callback("/<[^>]*>/i", create_function(
                                    '$matches',
                                    'return preg_replace("/ [^ =]*' . $allowattributes . '=(\"[^\"]*\"|\'[^\']*\')/i", "", $matches[0]);'
                            ), $string);
        }
        return $string;
    }

    /**
     * Make the title friendly
     */
    public static function url_friendly_name($title, $removeStopWord=false, $lang='en') {

        /* replace VI chars */
        $viChars = array('à', 'á', 'ả', 'ã', 'ạ', 'À', 'Á', 'Ả', 'Ã', 'Ạ', 'ă', 'ằ', 'ắ', 'ẳ', 'ẵ', 'ặ', 'Ă', 'Ằ', 'Ắ', 'Ẳ', 'Ẵ', 'Ặ', 'â', 'ầ', 'ấ', 'ẩ', 'ẫ', 'ậ', 'Â', 'Ầ', 'Ấ', 'Ẩ', 'Ẫ', 'Ậ', 'đ', 'Đ', 'è', 'é', 'ẻ', 'ẽ', 'ẹ', 'È', 'É', 'Ẻ', 'Ẽ', 'Ẹ', 'ê', 'ề', 'ế', 'ể', 'ễ', 'ệ', 'Ê', 'Ề', 'Ế', 'Ể', 'Ễ', 'Ệ', 'ì', 'í', 'ỉ', 'ĩ', 'ị', 'Ì', 'Í', 'Ỉ', 'Ĩ', 'Ị', 'ò', 'ó', 'ỏ', 'õ', 'ọ', 'Ò', 'Ó', 'Ỏ', 'Õ', 'Ọ', 'ô', 'ồ', 'ố', 'ổ', 'ỗ', 'ộ', 'Ô', 'Ồ', 'Ố', 'Ổ', 'Ỗ', 'Ộ', 'ơ', 'ờ', 'ớ', 'ở', 'ỡ', 'ợ', 'Ơ', 'Ờ', 'Ớ', 'Ở', 'Ỡ', 'Ợ', 'ù', 'ú', 'ủ', 'ũ', 'ụ', 'Ù', 'Ú', 'Ủ', 'Ũ', 'Ụ', 'ư', 'ừ', 'ứ', 'ử', 'ữ', 'ự', 'Ư', 'Ừ', 'Ứ', 'Ử', 'Ữ', 'Ự', 'ỳ', 'ý', 'ỷ', 'ỹ', 'ỵ', 'Ỳ', 'Ý', 'Ỷ', 'Ỹ', 'Ỵ');
        $replace = array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'd', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y');
        $title = str_replace($viChars, $replace, $title);

        /* remove tags */
        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

        /* lower */
        if (function_exists('mb_strtolower'))
            $title = mb_strtolower($title, 'UTF-8');
        else
            $title = strtolower($title);

        /* chinese ? */
        $cp = new ChinesePinyin();
        $title=$cp->translate($title);
        /* END: chinese */

        /* finaly */
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);
        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');

        /* done */
        return $title;
    }

    /**
     * Add nofollow to hyper links in string
     * @param string $string
     * @return string
     */
    public static function addNoFollow($string) {
        return preg_replace_callback('|<a (.+?)>|i', create_function('$matches', '$string = $matches[1];$string = str_replace(array(\' rel="nofollow"\', " rel=\'nofollow\'"), \'\', $string);$string = str_replace(array(\' rel="external"\', " rel=\'external\'"), \'\', $string);return "<a $string rel=\"nofollow\">";'), $string);
    }

    /**
     * Convert hyperlinks in string to redirected hyperlinks
     * @param string $string
     * @return string
     */
    public static function convertToBlankTargetLinks($string) {
        $return = preg_replace_callback('|<a[^>]+href=[\'"]([^>"\']+)[\'"][^>]*>([^<]+)</a>|i', create_function('$matches', 'Yii::app()->urlManager->urlFormat=\'get\';return CHtml::link($matches[2], $matches[1], array(\'target\'=>\'_blank\'));'), $string);
        Yii::app()->urlManager->urlFormat = 'path';
        return $return;
    }

    /**
     * Remove Overflow Text
     * @param string $string
     * @param int $length
     * @return string
     */
    public static function cutOverflowText($string, $length, $force=false) {
        if (mb_strlen($string) > $length) {
            $string = mb_substr($string, 0, $length);
            /* remove last word */
            if($force) return $string.'...';
            $last_space_pos=strrpos ($string, ' ');
            return substr($string, 0, $last_space_pos). ' ...';
        }
        return $string;
    }

}