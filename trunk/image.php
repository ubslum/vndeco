<?php

/* db info */
$db = require('protected/config/db.php');
preg_match('/mysql:host=(.+);dbname=(.+)/', $db['connectionString'], $match);
$host = $match[1];
$dbname = $match[2];

/* connect */
$conn = mysql_connect($host, $db['username'], $db['password']);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname);

if (isset($_GET['type'], $_GET['id']))
    switch ($_GET['type']) {
        case 'sliderImage':
            $column='filedata';
            if(isset($_GET['size']) && $_GET['size']=='small') $column='thumb1';
            if(isset($_GET['size']) && $_GET['size']=='medium') $column='thumb2';
            if(isset($_GET['size']) && $_GET['size']=='big') $column='thumb3';            
            $query = sprintf("SELECT `".$column."` FROM " . $db['tablePrefix'] . "slider_images WHERE id='%s'", mysql_real_escape_string($_GET['id']));
            $result = mysql_query($query);
            break;         
        case 'sliderThumb':
            $column='thumb1';
            if(isset($_GET['size']) && $_GET['size']=='small') $column='thumb1';
            if(isset($_GET['size']) && $_GET['size']=='medium') $column='thumb2';
            if(isset($_GET['size']) && $_GET['size']=='big') $column='thumb3';            
            $query = sprintf("SELECT `".$column."` FROM " . $db['tablePrefix'] . "slider_images WHERE id='%s'", mysql_real_escape_string($_GET['id']));
            $result = mysql_query($query);
            break;         
    }

if (!isset($result) || !$result) {
    die('No image');
}


/* out put */
//header('Cache-Control: max-age=28800');
header('Content-Type: image/jpeg');
$row = mysql_fetch_array($result, MYSQL_NUM);
echo $row[0];
/* end */
mysql_free_result($result);
