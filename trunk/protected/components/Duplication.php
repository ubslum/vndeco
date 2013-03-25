<?php
/*
 * $a = new Duplication();
 * $b = $a->checkDuplicate("<content>"); 
 * $b format: array(0=><dupe_link1>, 1=><dupe_link2>, ..., 'percent'=><percent>);
 */

class Duplication {
    public $database="";
    public $mysql_user = "";
    public $mysql_password = "";
    public $mysql_host = "";
    public $conn;
    public $apiKey = "";
    public $userip = "";
    public $stuffword = '';

    public function  __construct() {
        $this->mysql_host = "localhost";
        $this->apiKey = "ABQIAAAAcF48Jn23DqtelyNtP9vr3RRw7_MN2cM3_2sc-nm8FpTibsYroxRbK8cWTouthILvZVjMYXrK7VrO8A";
        $this->userip = "222.253.174.164";
        $this->init();
    }

    public function init() {

    }

    public function setApiKey($key) {
        $this->apiKey = $key;
    }

    public function setUserIp($ip) {
        $this->userip = $ip;
    }

    public function connectDB($host, $database, $username, $password) {
        $this->conn = mysql_connect($host, $username, $password) or die ('Error connecting to mysql');
        mysql_select_db($database);
    }

    public function closeConnectDB() {
        mysql_close($this->conn);
    }



    public function getMetaTitle($content) {
        $pattern = "|<[\s]*title[\s]*>([^<]+)<[\s]*/[\s]*title[\s]*>|Ui";
        if(preg_match($pattern, $content, $match))
            return $match[1];
        else
            return false;
    }

    public function getTitle($url) {
        $fh = fopen($url, "r");
        $str = fread($fh, 7500);  // read the first 7500 characters, it's gonna be near the top
        fclose($fh);
        $str2 = strtolower($str);
        $start = strpos($str2, "<title>")+7;
        $len   = strpos($str2, "</title>") - $start;
        return substr($str, $start, $len);
    }


    public function getMetaDescription($content) {
        $metaDescription = false;
        $metaDescriptionPatterns = array("/]*>/Ui", "/]*>/Ui");
        foreach ($metaDescriptionPatterns as $pattern) {
            if (preg_match($pattern, $content, $match))
                $metaDescription = $match[1];
            break;
        }
        return $metaDescription;
    }

    public function getDescription($url) {
        $a = get_meta_tags($url);
        return $a['description'];
    }

    public function getbodyContent($url) {
        $blah=file_get_contents($url);
        $pattern = "/<body>(.*)<\/body>/smi";
        preg_match_all($pattern, $blah, $matches);
        return $matches;
    }

    /*
     * use google ajax search api to search and get results
     * return a result array
     */
    public function get_data($keyword) {
        $keyword = urlencode($keyword);
        $url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&"
            . "q=".$keyword."&key=".$this->apiKey."&userip=".$this->userip;
        // sendRequest
        // note how referer is set manually
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_REFERER, /* Enter the URL of your site here */);
        $body = curl_exec($ch);
        curl_close($ch);
        // now, process the JSON string
        $json = json_decode($body);
        $searchs = $json->responseData->results;
        return $searchs;

    }

    public function checkDuplicate($content, $url=null) {
    //solve content into sentence
    //remove comment
        $d = preg_replace('/(<!--).(.*)(-->)/isU', '', $content);

        //remove script tag
        $e = preg_replace('/(<script.*>)(.*)(<\/script>)/imxsU', '', $d);

        //remove url
        $f = preg_replace('((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)', '', $e);

        //remove code tag
        $g = preg_replace('/(<code.*>)(.*)(<\/code>)/imxsU', '', $f);

        //remove b u i tag
        $h = preg_replace('/<b>|<\/b>|<u>|<\/u>|<i>|<\/i>|<strong>|<\/strong>|<em>|<\/em>|<sup>|<\/sup>|<a\b[^>]*(>)?(.*?)|<\/a>/', '', $g);

        //split tag
        $tag = "/<\/?\w+((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>|(\.)/i";
        $sentences = preg_split($tag, $h);

        $currentLink = $url;
        $dupLink = array();
        $wordCountDuplication = 0;
        $wordCountMain = 0;
        foreach($sentences as $sentence) {
            $sentence = iconv("UTF-8", "CP1252", $sentence);
            $sentence = strip_tags($sentence);
            $amongOfWordInSentence = str_word_count($sentence);
            $wordCountMain += str_word_count($sentence);
            $sentenceSearch = '"'.$sentence.'"';
            if($amongOfWordInSentence > 1) {
                $sentence = html_entity_decode($sentence);
                $sentence = preg_replace('/\s*\s/m',' ', $sentence);
                $sentence = trim($sentence);
                if(strlen($sentence) != 0) {
                    $googleResults='';
                    $resultSearchs = $this->get_data($sentenceSearch);
                    if($resultSearchs) {
                        foreach($resultSearchs as $resultSearch) {
                            if($currentLink != $resultSearch->unescapedUrl) {
                            //content of result search
                                $oneContents = explode('...', $resultSearch->content);
                                foreach($oneContents as $oneContent) {
                                    preg_match_all('/<b\b[^>]*>(.*?)<\/b>/', $oneContent, $googleResults);
                                    $countGoogleResult = count($googleResults[1]);
                                    $contentResult = trim(preg_replace('/\s*\s/m',' ', $googleResults[1][0]));
                                    $contentResult = str_replace(array('&#39;','&quot;'), array("'", '"'), $contentResult);
                                    $wordOfString1 = str_word_count($contentResult);
                                    for($i = 1; $i < $countGoogleResult; $i++) {
                                        if(strlen($contentResult)>0) {
                                            $wordOfString1 = str_word_count($contentResult);
                                            $wordOfString2 = str_word_count($googleResults[1][$i]);
                                            $content2 = trim(preg_replace('/\s*\s/m',' ', $googleResults[1][$i]));
                                            $content2 = str_replace(array('&#39;','&quot;'), array("'", '"'), $content2);
                                            if($content2 != '') {
                                                if($wordOfString1 >= $wordOfString2) {
                                                    if(substr_count($contentResult, $content2)==0) {
                                                        $contentResult .= ' ' . $content2;
                                                        $wordOfString1 = str_word_count($contentResult);
                                                    }else {
                                                        $countChk = substr_count($contentResult, $content2);
                                                        $countmain = substr_count($sentence, $content2);
                                                        if($countChk <  $countmain) {
                                                            $contentResult .= ' ' . $content2;
                                                            $wordOfString1 = str_word_count($contentResult);
                                                        }
                                                    }
                                                }else {
                                                    if(substr_count($content2, $contentResult)==0) {

                                                        $contentResult .= ' ' . $content2;
                                                        $wordOfString1 = str_word_count($contentResult);
                                                    }else {
                                                        $countChk = substr_count($content2, $contentResult);
                                                        $countmain = substr_count($sentence, $contentResult);
                                                        if($countChk <  $countmain) {
                                                            $contentResult .= ' ' . $content2;
                                                            $wordOfString1 = str_word_count($contentResult);
                                                        }
                                                    }
                                                }
                                            }
                                        }else {
                                            $content2 = trim(preg_replace('/\s*\s/m',' ', $googleResults[1][$i]));
                                            $content2 = str_replace(array('&#39;','&quot;'), array("'", '"'), $content2);
                                            $contentResult .= ' ' . $content2;
                                            $wordOfString1 = str_word_count($contentResult);
                                        }
                                        if($this->checkDuplicateContent($amongOfWordInSentence, $wordOfString1)) break;
                                    }
                                    if($this->checkDuplicateContent($amongOfWordInSentence, $wordOfString1)) break;
                                }
                                if($this->checkDuplicateContent($amongOfWordInSentence, $wordOfString1)) {
                                    $wordCountDuplication += str_word_count($sentence);
                                    if($currentLink != $resultSearch->unescapedUrl && !$this->checkLink($dupLink, $resultSearch->unescapedUrl)) {
                                        $dupLink[] = $resultSearch->unescapedUrl;
                                    }
                                    break ;
                                }else {
                                    $contentOfLinkTemp = @file_get_contents($resultSearch->unescapedUrl);
                                    if($contentOfLinkTemp != FALSE) {
                                        $contentOfLinkTemp = html_entity_decode($contentOfLinkTemp);
                                        $contentOfLinkTemp = trim(preg_replace('/\s*\s/m',' ', $contentOfLinkTemp));
                                        $contentOfLinkTemp = str_replace(array('&#39;','&quot;', '&nbsp;', '�', 'Â'), array("'", '"', '', '', ''), $contentOfLinkTemp);
                                        $contentOfLinkTemp = trim(preg_replace('/\s*\s/m',' ', $contentOfLinkTemp));
                                        $contentOfLinkTemp = trim(strip_tags($contentOfLinkTemp));
                                        $contentOfLink = $contentOfLinkTemp;
                                    }
                                    if(strlen($contentOfLink) > 0) {
                                        if(substr_count($contentOfLink, trim($sentence)) > 0) {
                                            if(!$this->checkLink($dupLink, $resultSearch->unescapedUrl))
                                                $dupLink[] = $resultSearch->unescapedUrl;
                                            $wordCountDuplication += str_word_count($sentence);
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if($wordCountDuplication!=0)
            $percent = $wordCountDuplication/$wordCountMain;
        $dupLink['percent']=$percent*100;
        return $dupLink;
    }

    public function checkDuplicateSentence($urlIn) {
        $sentences = $this->getContent($urlIn);
        //        var_dump($sentences);
        //        echo '<br />';
        $currentLink = $urlIn;
        $dupLink = array();
        $wordCountDuplication = 0;
        $wordCountMain = 0;
        foreach($sentences[0] as $sentence) {
            $sentence = iconv("UTF-8", "CP1252", $sentence);
            $sentence = strip_tags($sentence);
            $amongOfWordInSentence = str_word_count($sentence);
            $wordCountMain += str_word_count($sentence);
            //            echo 'main='.$wordCountMain . '<br />';
            $sentenceSearch = '"'.$sentence.'"';
            if($amongOfWordInSentence > 1) {
                $sentence = html_entity_decode($sentence);
                $sentence = preg_replace('/\s*\s/m',' ', $sentence);
                $sentence = trim($sentence);
                if(strlen($sentence) != 0) {
                    $googleResults='';
                    $resultSearchs = $this->get_data($sentenceSearch);
                    if($resultSearchs) {
                        foreach($resultSearchs as $resultSearch) {
                            if($currentLink != $resultSearch->unescapedUrl) {
                            //content of result search
                                $oneContents = explode('...', $resultSearch->content);
                                foreach($oneContents as $oneContent) {
                                    preg_match_all('/<b\b[^>]*>(.*?)<\/b>/', $oneContent, $googleResults);
                                    $countGoogleResult = count($googleResults[1]);
                                    $contentResult = trim(preg_replace('/\s*\s/m',' ', $googleResults[1][0]));
                                    $contentResult = str_replace(array('&#39;','&quot;'), array("'", '"'), $contentResult);
                                    $wordOfString1 = str_word_count($contentResult);
                                    for($i = 1; $i < $countGoogleResult; $i++) {
                                        if(strlen($contentResult)>0) {
                                            $wordOfString1 = str_word_count($contentResult);
                                            $wordOfString2 = str_word_count($googleResults[1][$i]);
                                            $content2 = trim(preg_replace('/\s*\s/m',' ', $googleResults[1][$i]));
                                            $content2 = str_replace(array('&#39;','&quot;'), array("'", '"'), $content2);
                                            if($content2 != '') {
                                                if($wordOfString1 >= $wordOfString2) {
                                                    if(substr_count($contentResult, $content2)==0) {
                                                        $contentResult .= ' ' . $content2;
                                                        $wordOfString1 = str_word_count($contentResult);
                                                    }else {
                                                        $countChk = substr_count($contentResult, $content2);
                                                        $countmain = substr_count($sentence, $content2);
                                                        if($countChk <  $countmain) {
                                                            $contentResult .= ' ' . $content2;
                                                            $wordOfString1 = str_word_count($contentResult);
                                                        }
                                                    }
                                                }else {
                                                    if(substr_count($content2, $contentResult)==0) {

                                                        $contentResult .= ' ' . $content2;
                                                        $wordOfString1 = str_word_count($contentResult);
                                                    }else {
                                                        $countChk = substr_count($content2, $contentResult);
                                                        $countmain = substr_count($sentence, $contentResult);
                                                        if($countChk <  $countmain) {
                                                            $contentResult .= ' ' . $content2;
                                                            $wordOfString1 = str_word_count($contentResult);
                                                        }
                                                    }
                                                }
                                            }
                                        }else {
                                            $content2 = trim(preg_replace('/\s*\s/m',' ', $googleResults[1][$i]));
                                            $content2 = str_replace(array('&#39;','&quot;'), array("'", '"'), $content2);
                                            $contentResult .= ' ' . $content2;
                                            $wordOfString1 = str_word_count($contentResult);
                                        }
                                        if($this->checkDuplicateContent($amongOfWordInSentence, $wordOfString1)) break;
                                    }
                                    if($this->checkDuplicateContent($amongOfWordInSentence, $wordOfString1)) break;
                                }
                                if($this->checkDuplicateContent($amongOfWordInSentence, $wordOfString1)) {
                                    $wordCountDuplication += str_word_count($sentence);
                                    //                                    echo 'dup = '.$wordCountDuplication.'<br />';
                                    //                                    echo $sentence.'<br />';
                                    if($currentLink != $resultSearch->unescapedUrl && !$this->checkLink($dupLink, $resultSearch->unescapedUrl)) {
                                        $dupLink[] = $resultSearch->unescapedUrl;
                                        break ;
                                    }
                                }else {
                                    $contentOfLinkTemp = @file_get_contents($resultSearch->unescapedUrl);
                                    if($contentOfLinkTemp != FALSE) {
                                        $contentOfLinkTemp = html_entity_decode($contentOfLinkTemp);
                                        $contentOfLinkTemp = trim(preg_replace('/\s*\s/m',' ', $contentOfLinkTemp));
                                        $contentOfLinkTemp = str_replace(array('&#39;','&quot;', '&nbsp;', '�', 'Â'), array("'", '"', '', '', ''), $contentOfLinkTemp);
                                        $contentOfLinkTemp = trim(preg_replace('/\s*\s/m',' ', $contentOfLinkTemp));
                                        $contentOfLinkTemp = trim(strip_tags($contentOfLinkTemp));
                                        $contentOfLink = $contentOfLinkTemp;
                                    }
                                    if(strlen($contentOfLink) > 0) {
                                        if(substr_count($contentOfLink, trim($sentence)) > 0) {
                                            if(!$this->checkLink($dupLink, $resultSearch->unescapedUrl))
                                                $dupLink[] = $resultSearch->unescapedUrl;
                                            $wordCountDuplication += str_word_count($sentence);
                                            //                                            echo 'dup = '.$wordCountDuplication.'<br />';
                                            //                                            echo $sentence.'<br />';
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if($wordCountDuplication!=0)
            $percent = $wordCountDuplication/$wordCountMain;
        $dupLink['percent']=$percent*100;
        return $dupLink;
    }

    public function checkDuplicateSentence2($url) {
        $link = array();
        $i=0;
        $contents = $this->getContent($url);
        //        echo 'total=' . $contents['total'] . '<br />';
        if($contents[0]) {
            foreach($contents[0] as $sen) {

            //                $sen = iconv("UTF-8", "CP1252", $sen);
            //                $sen = html_entity_decode($sen);
            //                $sen = utf8_decode($sen);
            //$sen = htmlentities($sen);

                $sen = preg_replace('/\s*\s/m',' ', $sen);
                //                echo $sen . '<br />';
                $sen = trim($sen);

                //                            echo '<br />=======================================================<br />';
                //                            echo 'sentence: '. $sen . '<br />';
                $sentenceSearch = '"'.$sen.'"';//$this->removeStopWord($sen);
                $countWordInSentence = str_word_count($sen);
                if($countWordInSentence > 0) {
                //                    echo $sen .'<br />';
                    $resultSearchs = $this->get_data($sentenceSearch);
                    if($resultSearchs) {
                        foreach($resultSearchs as $resultSearch) {
                            if($url != $resultSearch->unescapedUrl) {
                                if(count($link)>9)
                                    return $link;
                                if(!$this->checkExistLink($resultSearch->unescapedUrl, $link)) {
                                    $wordOfResultSearch = 0;
                                    $wordOfSentence = 0;
                                    $c = $this->getContent($resultSearch->unescapedUrl);
                                    if(count($c[0])>1) {
                                    //                                        foreach($c[0] as $d) {//count word of content result
                                    //                                            $wordOfResultSearch += str_word_count($d);
                                    //                                        }
                                        foreach($contents[1] as $s) {
                                        //                                            if(in_array($s, $c[1])) {
                                        //                                                $wordOfSentence += str_word_count($s);
                                        //                                            //                                                echo $wordOfSentence . '<br />';
                                        //                                            }
                                            if($this->compareSentence($s, $c[1])) {
                                                echo $s.'<br />';
                                                $wordOfSentence += str_word_count($s);
                                            }
                                        }
                                        if($wordOfSentence!=0) {
                                            $percent = $wordOfSentence/$contents['total'];
                                            $percent = round($percent, 4);
                                            $link[$i]['url'] = trim($resultSearch->unescapedUrl);
                                            $link[$i]['percent'] = $percent;
                                            $i++;
                                        //                                        echo 'url='.trim($resultSearch->unescapedUrl).'<br />';
                                        //                                        echo 'percent='.$percent.'<br />';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $link;
    }

    protected function checkExistLink($url, $arr) {
        foreach($arr as $a) {
            if($a['url']==trim($url))
                return true;
        }
        return false;
    }

     /*
     * check duplication content
     */
    public function checkDuplicateContent($wordCountOfMainContent, $wordCountOfCheckContent) {
        $percent = $wordCountOfCheckContent/$wordCountOfMainContent*100;
        if($percent > 60)
            return true;
        else
            return false;
    }

    public function checkLink($arrayLink, $link) {
        foreach($arrayLink as $a) {
            if($a == $link)
                return true;
        }
        return false;
    }

    public function getContent($url) {
        $content=array();
        $countWord = 0;
        $b = @file_get_contents($url);
        if($b != FALSE) {
//            preg_match( '@<meta\s+http-equiv="Content-Type"\s+content="([\w/]+)(;\s+charset=([^\s"]+))?@i', $b, $matches );
//            $encoding = $matches[3];
//
//            /* Convert to UTF-8 before doing anything else */
//            if ($encoding!="utf-8" && $encoding!=null) {
//                $b = iconv($encoding, "utf-8", $b );
//            }

            //get body
            $a1 = preg_match_all('/(<body.*>)(\w.*)(<\/body>)/is',$b,$c);

            //remove comment
            $d = preg_replace('/(<!--).(.*)(-->)/isU', '', $c[0][0]);

            //remove script tag
            $e = preg_replace('/(<script.*>)(.*)(<\/script>)/imxsU', '', $d);

            //remove url
            $f = preg_replace('((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)', '', $e);

            //remove code tag
            $g = preg_replace('/(<code.*>)(.*)(<\/code>)/imxsU', '', $f);

            //remove b u i tag
            $h = preg_replace('/<b>|<\/b>|<u>|<\/u>|<i>|<\/i>|<strong>|<\/strong>|<em>|<\/em>|<sup>|<\/sup>|<a\b[^>]*(>)?(.*?)|<\/a>/', '', $g);

            //split tag
            $tag = "/<\/?\w+((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/i";
            $i = preg_split($tag, $h);

            foreach($i as $test) {//get paragraph

                $arrs = explode('.', $test);
                foreach($arrs as $arr) {//get sentence
                    $s = trim($arr);
                    $s = iconv("UTF-8", "CP1252", $s);
                    //                    $ssss = mb_detect_encoding($s);
                    //                    $s = utf8_decode($s);
                    //echo $s . '<br />';
                    if($s!='') {
                        if(str_word_count($s)>7) {
                        //                            echo str_word_count($s).':'.$s.'<br />';

                            $content[0][] = $s;
                            $content[1][] = strtolower($s);
                            $countWord += str_word_count($s);
                        }
                    //                        }
                    }
                }
            }
        }
        $content['total'] = $countWord;
        return $content;
    }

    public function getStopWord($path) {
        $common = array();

        $lines = @file(Yii::app()->basePath. '/components/stopword.txt');

        if (is_array($lines)) {
            while (list($id, $word) = each($lines)) {
                $common[] = trim($word);
                $common["stuffword"] .= trim($word) . ' ';
            }
        }
        $common["stuffword"] = substr($common["stuffword"], 0, -1);
        return $common;
    }

    public function removeStopWord($sentence) {
        if(strlen(trim($sentence))>0) {
            $search = '"';
            $words = explode(' ', $sentence);
            //$a = file_get_contents(Yii::app()->basePath. '/components/stopword.txt');
            foreach($words as $word) {
                if(substr_count($this->stuffword, $word))
                    $word = '" "';
                $search .= $word . ' ';
            }
            $search .= '"';
            $search = iconv("UTF-8", "CP1252", $search);
        }
        return $search;
    }

    public function getStuffWord() {
        return $this->stuffword;
    }

    public function setStuffWord($path) {
        $common = array();

        $lines = @file($path); //Yii::app()->basePath. '/components/stopword.txt'

        if (is_array($lines)) {
            while (list($id, $word) = each($lines)) {
                $common[] = trim($word);
                $common["stuffword"] .= trim($word) . ' ';
            }
        }
        $common["stuffword"] = substr($common["stuffword"], 0, -1);
        $this->stuffword = $common["stuffword"];
        return $common;
    }

    public function compareSentence($sentence1, $content) {
        $countContent1 = str_word_count($sentence1);
        //        echo '===============================<br />';
        //        echo $sentence1 . '<br />';
        //        $sentence1 = iconv("UTF-8", "CP1252", $sentence1);
        $s = explode(' ', $sentence1);
        //        var_dump($s);
        //        echo '<br />';
        $countSen = 0;
        foreach($content as $sentence) {
            $s1 = '';
            if(strlen($sentence)>1) {
            //            $sentence = iconv("UTF-8", "CP1252", $sentence);
                $countContent = str_word_count($sentence);
                //                echo 'ssss ' . $sentence . ' ssss<br />';
                foreach($s as $word) {
                    if(str_word_count(word)>0 && trim($word)!='') {
                    //                        echo $word . '|';
                        if(substr_count($sentence, $word)>0)
                            $s1 .= $word . ' ';
                        $countSen = str_word_count($s1);
                        $a = $countSen/$countContent;
                        //                    echo $a . ' ';
                        if($countSen/$countContent > 0.65 && $countSen/$countContent1 > 0.65) {
                        //                            echo $s1;
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }














    public function getFileContents($url) {
        global $user_agent;
        $urlparts = parse_url($url);
        $path = $urlparts['path'];
        $host = $urlparts['host'];
        if ($urlparts['query'] != "")
            $path .= "?".$urlparts['query'];
        if (isset ($urlparts['port'])) {
            $port = (int) $urlparts['port'];
        } else
            if ($urlparts['scheme'] == "http") {
                $port = 80;
            } else
                if ($urlparts['scheme'] == "https") {
                    $port = 443;
                }

        if ($port == 80) {
            $portq = "";
        } else {
            $portq = ":$port";
        }

        $all = "*/*";

        $request = "GET $path HTTP/1.0\r\nHost: $host$portq\r\nAccept: $all\r\nUser-Agent: $user_agent\r\n\r\n";

        $fsocket_timeout = 30;
        if (substr($url, 0, 5) == "https") {
            $target = "ssl://".$host;
        } else {
            $target = $host;
        }


        $errno = 0;
        $errstr = "";
        $fp = @ fsockopen($target, $port, $errno, $errstr, $fsocket_timeout);

        print $errstr;
        if (!$fp) {
            $contents['state'] = "NOHOST";
            printConnectErrorReport($errstr);
            return $contents;
        } else {
            if (!fputs($fp, $request)) {
                $contents['state'] = "Cannot send request";
                return $contents;
            }
            $data = null;
            socket_set_timeout($fp, $fsocket_timeout);
            do {
                $status = socket_get_status($fp);
                $data .= fgets($fp, 8192);
            } while (!feof($fp) && !$status['timed_out']) ;

            fclose($fp);
            if ($status['timed_out'] == 1) {
                $contents['state'] = "timeout";
            } else
                $contents['state'] = "ok";
            $contents['file'] = substr($data, strpos($data, "\r\n\r\n") + 4);
        }
        return $contents;
    }

    /*
check if file is available and in readable form
*/
    public function url_status($url) {
        global $user_agent, $index_pdf, $index_doc, $index_xls, $index_ppt;
        $urlparts = parse_url($url);
        $path = $urlparts['path'];
        $host = $urlparts['host'];
        if (isset($urlparts['query']))
            $path .= "?".$urlparts['query'];

        if (isset ($urlparts['port'])) {
            $port = (int) $urlparts['port'];
        } else
            if ($urlparts['scheme'] == "http") {
                $port = 80;
            } else
                if ($urlparts['scheme'] == "https") {
                    $port = 443;
                }

        if ($port == 80) {
            $portq = "";
        } else {
            $portq = ":$port";
        }

        $all = "*/*"; //just to prevent "comment effect" in get accept
        $request = "HEAD $path HTTP/1.1\r\nHost: $host$portq\r\nAccept: $all\r\nUser-Agent: $user_agent\r\n\r\n";

        if (substr($url, 0, 5) == "https") {
            $target = "ssl://".$host;
        } else {
            $target = $host;
        }

        $fsocket_timeout = 30;
        $errno = 0;
        $errstr = "";
        $fp = fsockopen($target, $port, $errno, $errstr, $fsocket_timeout);
        print $errstr;
        $linkstate = "ok";
        if (!$fp) {
            $status['state'] = "NOHOST";
        } else {
            socket_set_timeout($fp, 30);
            fputs($fp, $request);
            $answer = fgets($fp, 4096);
            $regs = Array ();
            if (preg_match("/HTTP[0-9.]+ (([0-9])[0-9]{2})/", $answer, $regs)) {
                $httpcode = $regs[2];
                $full_httpcode = $regs[1];

                if ($httpcode <> 2 && $httpcode <> 3) {
                    $status['state'] = "Unreachable: http $full_httpcode";
                    $linkstate = "Unreachable";
                }
            }

            if ($linkstate <> "Unreachable") {
                while ($answer) {
                    $answer = fgets($fp, 4096);

                    if (preg_match("/Location: *([^\n\r ]+)/", $answer, $regs) && $httpcode == 3 && $full_httpcode != 302) {
                        $status['path'] = $regs[1];
                        $status['state'] = "Relocation: http $full_httpcode";
                        fclose($fp);
                        return $status;
                    }

                    if (preg_match("/Last-Modified: *([a-z0-9,: ]+)/i", $answer, $regs)) {
                        $status['date'] = $regs[1];
                    }

                    if (preg_match("/Content-Type:/i", $answer)) {
                        $content = $answer;
                        $answer = '';
                        break;
                    }
                }
                $socket_status = socket_get_status($fp);
                if (preg_match("/Content-Type: *([a-z\/.-]*)/i", $content, $regs)) {
                    if ($regs[1] == 'text/html' || $regs[1] == 'text/' || $regs[1] == 'text/plain') {
                        $status['content'] = 'text';
                        $status['state'] = 'ok';
                    } else if ($regs[1] == 'application/pdf' && $index_pdf == 1) {
                            $status['content'] = 'pdf';
                            $status['state'] = 'ok';
                        } else if (($regs[1] == 'application/msword' || $regs[1] == 'application/vnd.ms-word') && $index_doc == 1) {
                                $status['content'] = 'doc';
                                $status['state'] = 'ok';
                            } else if (($regs[1] == 'application/excel' || $regs[1] == 'application/vnd.ms-excel') && $index_xls == 1) {
                                    $status['content'] = 'xls';
                                    $status['state'] = 'ok';
                                } else if (($regs[1] == 'application/mspowerpoint' || $regs[1] == 'application/vnd.ms-powerpoint') && $index_ppt == 1) {
                                        $status['content'] = 'ppt';
                                        $status['state'] = 'ok';
                                    } else {
                                        $status['state'] = "Not text or html";
                                    }

                } else
                    if ($socket_status['timed_out'] == 1) {
                        $status['state'] = "Timed out (no reply from server)";

                    } else
                        $status['state'] = "Not text or html";

            }
        }
        fclose($fp);
        return $status;
    }

    /*
Read robots.txt file in the server, to find any disallowed files/folders
*/
    public function check_robot_txt($url) {
        global $user_agent;
        $urlparts = parse_url($url);
        $url = 'http://'.$urlparts['host']."/robots.txt";

        $url_status = url_status($url);
        $omit = array ();

        if ($url_status['state'] == "ok") {
            $robot = file($url);
            if (!$robot) {
                $contents = getFileContents($url);
                $file = $contents['file'];
                $robot = explode("\n", $file);
            }

            $regs = Array ();
            $this_agent= "";
            while (list ($id, $line) = each($robot)) {
                if (preg_match("/^user-agent: *([^#]+) */", $line, $regs)) {
                    $this_agent = trim($regs[1]);
                    if ($this_agent == '*' || $this_agent == $user_agent)
                        $check = 1;
                    else
                        $check = 0;
                }

                if (preg_match("/disallow: *([^#]+)/", $line, $regs) && $check == 1) {
                    $disallow_str = preg_replace("/[\n ]+/i", "", $regs[1]);
                    if (trim($disallow_str) != "") {
                        $omit[] = $disallow_str;
                    } else {
                        if ($this_agent == '*' || $this_agent == $user_agent) {
                            return null;
                        }
                    }
                }
            }
        }

        return $omit;
    }

















    function get_content($url) {
        $options = array(
            'return_info'	=> true,
            'method'		=> 'post'
        );
        $result = $this->load($url, $options);
        return $result;
    }

    function load($url,$options=array()) {
        $default_options = array(
            'method'        => 'get',
            'post_data'        => false,
            'return_info'    => false,
            'return_body'    => true,
            'cache'            => false,
            'referer'        => '',
            'headers'        => array(),
            'session'        => false,
            'session_close'    => false,
        );
        // Sets the default options.
        foreach($default_options as $opt=>$value) {
            if(!isset($options[$opt])) $options[$opt] = $value;
        }

        $url_parts = parse_url($url);
        $ch = false;
        $info = array(//Currently only supported by curl.
            'http_code'    => 200
        );
        $response = '';

        $send_header = array(
            'Accept' => 'text/*',
            'User-Agent' => 'BinGet/1.00.A (http://www.bin-co.com/php/scripts/load/)'
            ) + $options['headers']; // Add custom headers provided by the user.

        if($options['cache']) {
            $cache_folder = joinPath(sys_get_temp_dir(), 'php-load-function');
            if(isset($options['cache_folder'])) $cache_folder = $options['cache_folder'];
            if(!file_exists($cache_folder)) {
                $old_umask = umask(0); // Or the folder will not get write permission for everybody.
                mkdir($cache_folder, 0777);
                umask($old_umask);
            }

            $cache_file_name = md5($url) . '.cache';
            $cache_file = joinPath($cache_folder, $cache_file_name); //Don't change the variable name - used at the end of the function.

            if(file_exists($cache_file)) { // Cached file exists - return that.
                $response = file_get_contents($cache_file);

                //Seperate header and content
                $separator_position = strpos($response,"\r\n\r\n");
                $header_text = substr($response,0,$separator_position);
                $body = substr($response,$separator_position+4);

                foreach(explode("\n",$header_text) as $line) {
                    $parts = explode(": ",$line);
                    if(count($parts) == 2) $headers[$parts[0]] = chop($parts[1]);
                }
                $headers['cached'] = true;

                if(!$options['return_info']) return $body;
                else return array('headers' => $headers, 'body' => $body, 'info' => array('cached'=>true));
            }
        }

        if(isset($options['post_data'])) { //There is an option to specify some data to be posted.
            $options['method'] = 'post';

            if(is_array($options['post_data'])) { //The data is in array format.
                $post_data = array();
                foreach($options['post_data'] as $key=>$value) {
                    $post_data[] = "$key=" . urlencode($value);
                }
                $url_parts['query'] = implode('&', $post_data);
            } else { //Its a string
                $url_parts['query'] = $options['post_data'];
            }
        } elseif(isset($options['multipart_data'])) { //There is an option to specify some data to be posted.
            $options['method'] = 'post';
            $url_parts['query'] = $options['multipart_data'];
        /*
            This array consists of a name-indexed set of options.
            For example,
            'name' => array('option' => value)
            Available options are:
            filename: the name to report when uploading a file.
            type: the mime type of the file being uploaded (not used with curl).
            binary: a flag to tell the other end that the file is being uploaded in binary mode (not used with curl).
            contents: the file contents. More efficient for fsockopen if you already have the file contents.
            fromfile: the file to upload. More efficient for curl if you don't have the file contents.

            Note the name of the file specified with fromfile overrides filename when using curl.
         */
        }

        ///////////////////////////// Curl /////////////////////////////////////
        //If curl is available, use curl to get the data.
        if(function_exists("curl_init")
            and (!(isset($options['use']) and $options['use'] == 'fsocketopen'))) { //Don't use curl if it is specifically stated to use fsocketopen in the options

            if(isset($options['post_data'])) { //There is an option to specify some data to be posted.
                $page = $url;
                $options['method'] = 'post';

                if(is_array($options['post_data'])) { //The data is in array format.
                    $post_data = array();
                    foreach($options['post_data'] as $key=>$value) {
                        $post_data[] = "$key=" . urlencode($value);
                    }
                    $url_parts['query'] = implode('&', $post_data);

                } else { //Its a string
                    $url_parts['query'] = $options['post_data'];
                }
            } else {
                if(isset($options['method']) and $options['method'] == 'post') {
                    $page = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'];
                } else {
                    $page = $url;
                }
            }

            if($options['session'] and isset($GLOBALS['_binget_curl_session'])) $ch = $GLOBALS['_binget_curl_session']; //Session is stored in a global variable
            else $ch = curl_init($url_parts['host']);

            curl_setopt($ch, CURLOPT_URL, $page) or die("Invalid cURL Handle Resouce");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Just return the data - not print the whole thing.
            curl_setopt($ch, CURLOPT_HEADER, true); //We need the headers
            curl_setopt($ch, CURLOPT_NOBODY, !($options['return_body'])); //The content - if true, will not download the contents. There is a ! operation - don't remove it.
            $tmpdir = NULL; //This acts as a flag for us to clean up temp files
            if(isset($options['method']) and $options['method'] == 'post' and isset($url_parts['query'])) {
                curl_setopt($ch, CURLOPT_POST, true);
                if(is_array($url_parts['query'])) {
                //multipart form data (eg. file upload)
                    $postdata = array();
                    foreach ($url_parts['query'] as $name => $data) {
                        if (isset($data['contents']) && isset($data['filename'])) {
                            if (!isset($tmpdir)) { //If the temporary folder is not specifed - and we want to upload a file, create a temp folder.
                            //  :TODO:
                                $dir = sys_get_temp_dir();
                                $prefix = 'load';

                                if (substr($dir, -1) != '/') $dir .= '/';
                                do {
                                    $path = $dir . $prefix . mt_rand(0, 9999999);
                                } while (!mkdir($path, $mode));

                                $tmpdir = $path;
                            }
                            $tmpfile = $tmpdir.'/'.$data['filename'];
                            file_put_contents($tmpfile, $data['contents']);
                            $data['fromfile'] = $tmpfile;
                        }
                        if (isset($data['fromfile'])) {
                        // Not sure how to pass mime type and/or the 'use binary' flag
                            $postdata[$name] = '@'.$data['fromfile'];
                        } elseif (isset($data['contents'])) {
                            $postdata[$name] = $data['contents'];
                        } else {
                            $postdata[$name] = '';
                        }
                    }
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $url_parts['query']);
                }
            }

            //Set the headers our spiders sends
            curl_setopt($ch, CURLOPT_USERAGENT, $send_header['User-Agent']); //The Name of the UserAgent we will be using ;)
            $custom_headers = array("Accept: " . $send_header['Accept'] );
            if(isset($options['modified_since']))
                array_push($custom_headers,"If-Modified-Since: ".gmdate('D, d M Y H:i:s \G\M\T',strtotime($options['modified_since'])));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);
            if($options['referer']) curl_setopt($ch, CURLOPT_REFERER, $options['referer']);

            curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/binget-cookie.txt"); //If ever needed...
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $custom_headers = array();
            unset($send_header['User-Agent']); // Already done (above)
            foreach ($send_header as $name => $value) {
                if (is_array($value)) {
                    foreach ($value as $item) {
                        $custom_headers[] = "$name: $item";
                    }
                } else {
                    $custom_headers[] = "$name: $value";
                }
            }
            if(isset($url_parts['user']) and isset($url_parts['pass'])) {
                $custom_headers[] = "Authorization: Basic ".base64_encode($url_parts['user'].':'.$url_parts['pass']);
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);

            $response = curl_exec($ch);

            if(isset($tmpdir)) {
            //rmdirr($tmpdir); //Cleanup any temporary files :TODO:
            }

            $info = curl_getinfo($ch); //Some information on the fetch

            if($options['session'] and !$options['session_close']) $GLOBALS['_binget_curl_session'] = $ch; //Dont close the curl session. We may need it later - save it to a global variable
            else curl_close($ch);  //If the session option is not set, close the session.

        //////////////////////////////////////////// FSockOpen //////////////////////////////
        } else { //If there is no curl, use fsocketopen - but keep in mind that most advanced features will be lost with this approch.

            if(!isset($url_parts['query']) || (isset($options['method']) and $options['method'] == 'post'))
                $page = $url_parts['path'];
            else
                $page = $url_parts['path'] . '?' . $url_parts['query'];

            if(!isset($url_parts['port'])) $url_parts['port'] = ($url_parts['scheme'] == 'https' ? 443 : 80);
            $host = ($url_parts['scheme'] == 'https' ? 'ssl://' : '').$url_parts['host'];
            $fp = fsockopen($host, $url_parts['port'], $errno, $errstr, 30);
            if ($fp) {
                $out = '';
                if(isset($options['method']) and $options['method'] == 'post' and isset($url_parts['query'])) {
                    $out .= "POST $page HTTP/1.1\r\n";
                } else {
                    $out .= "GET $page HTTP/1.0\r\n"; //HTTP/1.0 is much easier to handle than HTTP/1.1
                }
                $out .= "Host: $url_parts[host]\r\n";
                foreach ($send_header as $name => $value) {
                    if (is_array($value)) {
                        foreach ($value as $item) {
                            $out .= "$name: $item\r\n";
                        }
                    } else {
                        $out .= "$name: $value\r\n";
                    }
                }
                $out .= "Connection: Close\r\n";

                //HTTP Basic Authorization support
                if(isset($url_parts['user']) and isset($url_parts['pass'])) {
                    $out .= "Authorization: Basic ".base64_encode($url_parts['user'].':'.$url_parts['pass']) . "\r\n";
                }

                //If the request is post - pass the data in a special way.
                if(isset($options['method']) and $options['method'] == 'post') {
                    if(is_array($url_parts['query'])) {
                    //multipart form data (eg. file upload)

                    // Make a random (hopefully unique) identifier for the boundary
                        srand((double)microtime()*1000000);
                        $boundary = "---------------------------".substr(md5(rand(0,32000)),0,10);

                        $postdata = array();
                        $postdata[] = '--'.$boundary;
                        foreach ($url_parts['query'] as $name => $data) {
                            $disposition = 'Content-Disposition: form-data; name="'.$name.'"';
                            if (isset($data['filename'])) {
                                $disposition .= '; filename="'.$data['filename'].'"';
                            }
                            $postdata[] = $disposition;
                            if (isset($data['type'])) {
                                $postdata[] = 'Content-Type: '.$data['type'];
                            }
                            if (isset($data['binary']) && $data['binary']) {
                                $postdata[] = 'Content-Transfer-Encoding: binary';
                            } else {
                                $postdata[] = '';
                            }
                            if (isset($data['fromfile'])) {
                                $data['contents'] = file_get_contents($data['fromfile']);
                            }
                            if (isset($data['contents'])) {
                                $postdata[] = $data['contents'];
                            } else {
                                $postdata[] = '';
                            }
                            $postdata[] = '--'.$boundary;
                        }
                        $postdata = implode("\r\n", $postdata)."\r\n";
                        $length = strlen($postdata);
                        $postdata = 'Content-Type: multipart/form-data; boundary='.$boundary."\r\n".
                            'Content-Length: '.$length."\r\n".
                            "\r\n".
                            $postdata;

                        $out .= $postdata;
                    } else {
                        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
                        $out .= 'Content-Length: ' . strlen($url_parts['query']) . "\r\n";
                        $out .= "\r\n" . $url_parts['query'];
                    }
                }
                $out .= "\r\n";

                fwrite($fp, $out);
                while (!feof($fp)) {
                    $response .= fgets($fp, 128);
                }
                fclose($fp);
            }
        }

        //Get the headers in an associative array
        $headers = array();

        if($info['http_code'] == 404) {
            $body = "";
            $headers['Status'] = 404;
        } else {
        //Seperate header and content
            $header_text = substr($response, 0, $info['header_size']);
            $body = substr($response, $info['header_size']);

            foreach(explode("\n",$header_text) as $line) {
                $parts = explode(": ",$line);
                if(count($parts) == 2) {
                    if (isset($headers[$parts[0]])) {
                        if (is_array($headers[$parts[0]])) $headers[$parts[0]][] = chop($parts[1]);
                        else $headers[$parts[0]] = array($headers[$parts[0]], chop($parts[1]));
                    } else {
                        $headers[$parts[0]] = chop($parts[1]);
                    }
                }
            }

        }

        if(isset($cache_file)) { //Should we cache the URL?
            file_put_contents($cache_file, $response);
        }

        if($options['return_info']) return array('headers' => $headers, 'body' => $body, 'info' => $info, 'curl_handle'=>$ch);
        return $body;
    }
}
