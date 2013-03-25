<?php

/**
 * KeywordGen
 * @author Gia Duy (admin@giaduy.info)
 */
class KeywordGen {
    /**
     * Remove Stop Words base on language
     * @param string $string string need to remove stop words
     * @param strong $lang the stop word language stop word, if null use Yii language
     * @return string after remove stop words
     */
    public static function removeStopWords($string, $lang) {
        $stopWords = self::getStopWordList($lang);
        foreach ($stopWords as $word)
            $string = str_ireplace('[' . $word . ']', '', $string);
        return $string;
    }

    /**
     * Get stopword list by language
     */
    public static function getStopWordList($lang) {
        /* load stopword list */
        $sql = 'SELECT word FROM {{stopwords}} WHERE lang=:lang ORDER BY word';
        $commd = Yii::app()->db->createCommand($sql);
        $commd->bindValue(':lang', $lang);
        return $commd->queryColumn();
    }

    /**
     * Generate Keywords
     */
    public static function generateKeywords($contents, $lang=null, $length=200) {
        if ($lang === null)
            $lang = Yii::app()->language;

        /* replace chars */
        //$contents = ContentHandler::removeNonUtfAlnum($contents);
        //$contents = ContentHandler::reduceWhitespace(strip_tags($contents));

        $w3 = self:: parse3words($contents, $lang);
        //echo $w3;
        $w2 = self:: parse2words($contents, $lang);
        //echo $w2;
        $w1 = self:: parseWord($contents, $lang);
        //echo $w1;

        $w = '';
        if ($w3 != '')
            $w.=$w3;
        if ($w2 != '') {
            if ($w != '')
                $w.=', ' . $w2;
            else
                $w.=$w2;
        }
        if ($w1 != '') {
            if ($w != '')
                $w.=', ' . $w1;
            else
                $w.=$w1;
        }


        $keywords= substr(substr($w, 0, $length), 0, strrpos(substr($w, 0, $length), ','));
        return $keywords;
    }

    /**
     * Generate 3Words Keywords
     */
    public function parse3words($contents, $lang=NULL) {
        //create an array out of the site contents
        $a = split(" ", $contents);
        //initilize array
        $b = array();

        for ($i = 0; $i < count($a) - 2; $i++) {
            //delete phrases lesser than x characters
            if ((mb_strlen(trim($a[$i])) >= Yii::app()->params['autoKeyword']['min_3words_length']) && (mb_strlen(trim($a[$i + 1])) >= Yii::app()->params['autoKeyword']['min_3words_length']) && (mb_strlen(trim($a[$i + 2])) >= Yii::app()->params['autoKeyword']['min_3words_length'])) {
                $b[] = trim($a[$i]) . " " . trim($a[$i + 1]) . " " . trim($a[$i + 2]);
            }
        }

        /* count the 3 word phrases */
        $b = array_count_values($b);
        /* sort the words from highest count to the lowest. */
        $occur_filtered = self::occure_filter($b, Yii::app()->params['autoKeyword']['min_3words_phrase_occur']);
        arsort($occur_filtered);

        /* remove non dictionary word */
        $words = array_keys($occur_filtered);
        if (file_exists(dirname(__FILE__) . '/data/' . $lang . '.php')) {
            $dics = require(dirname(__FILE__) . '/data/' . $lang . '.php');
            foreach ($words as $word)
                if (!in_array($word, $dics))
                    unset($occur_filtered[$word]);
        }

        /* remove stopwords */
        $imploded = substr('[' . self::implode("][", $occur_filtered), 0, -1);
        $keywords = self::removeStopWords($imploded, $lang);
        $search = array('][', '[', ']');
        $replace = array(', ', '', '');
        $keywords = mb_strtolower(str_replace($search, $replace, $keywords));

        return $keywords;
    }

    /**
     * Generate 2Words Keywords
     */
    public function parse2words($contents, $lang=NULL) {
        //create an array out of the site contents
        $x = split(" ", $contents);

        //initilize array
        $y = array();

        for ($i = 0; $i < count($x) - 1; $i++) {
            //delete phrases lesser than 5 characters
            if ((mb_strlen(trim($x[$i])) >= Yii::app()->params['autoKeyword']['min_2words_length'] ) && (mb_strlen(trim($x[$i + 1])) >= Yii::app()->params['autoKeyword']['min_2words_length'])) {
                $y[] = trim($x[$i]) . " " . trim($x[$i + 1]);
            }
        }

        //count the 3 word phrases
        $y = array_count_values($y);

        //sort the words from
        //highest count to the
        //lowest.
        $occur_filtered = self::occure_filter($y, Yii::app()->params['autoKeyword']['min_2words_phrase_occur']);

        arsort($occur_filtered);

        /* remove non dictionary word */
        $words = array_keys($occur_filtered);
        if (file_exists(dirname(__FILE__) . '/data/' . $lang . '.php')) {
            $dics = require(dirname(__FILE__) . '/data/' . $lang . '.php');
            foreach ($words as $word)
                if (!in_array($word, $dics))
                    unset($occur_filtered[$word]);
        }


        /* remove stopwords */
        $imploded = substr('[' . self::implode("][", $occur_filtered), 0, -1);
        $keywords = self::removeStopWords($imploded, $lang);
        $search = array('][', '[', ']');
        $replace = array(', ', '', '');
        $keywords = mb_strtolower(str_replace($search, $replace, $keywords));
        /* end remove stopwords */

        return $keywords;
    }

    /**
     * Generate 1 word Keyword
     */
    function parseWord($contents, $lang) {
        //create an array out of the site contents
        $s = split(" ", $contents);
        //initialize array
        $k = array();
        //iterate inside the array
        foreach ($s as $key => $val) {
            //delete single or two letter words and
            //Add it to the list if the word is not
            //contained in the common words list.
            if (mb_strlen(trim($val)) >= Yii::app()->params['autoKeyword']['min_word_length']) {
                $k[] = trim($val);
            }
        }
        //count the words
        $k = array_count_values($k);
        //sort the words from
        //highest count to the
        //lowest.
        $occur_filtered = self::occure_filter($k, Yii::app()->params['autoKeyword']['min_word_occur']);
        arsort($occur_filtered);

        /* remove non dictionary word */
        $words = array_keys($occur_filtered);
        if (file_exists(dirname(__FILE__) . '/data/' . $lang . '.php')) {
            $dics = require(dirname(__FILE__) . '/data/' . $lang . '.php');
            foreach ($words as $word)
                if (!in_array($word, $dics))
                    unset($occur_filtered[$word]);
        }

        /* remove stopwords */
        $imploded = substr('[' . self::implode("][", $occur_filtered), 0, -1);
        $keywords = self::removeStopWords($imploded, $lang);
        $search = array('][', '[', ']');
        $replace = array(', ', '', '');
        $keywords = mb_strtolower(str_replace($search, $replace, $keywords));
        /* end remove stopwords */

        return $keywords;
    }

    public function occure_filter($array_count_values, $min_occur) {
        $occur_filtered = array();
        foreach ($array_count_values as $word => $occured) {
            if ($occured >= $min_occur) {
                $occur_filtered[$word] = $occured;
            }
        }
        return $occur_filtered;
    }

    public function implode($gule, $array) {
        $c = "";
        foreach ($array as $key => $val) {
            @$c .= $key . $gule;
        }
        return $c;
    }

}