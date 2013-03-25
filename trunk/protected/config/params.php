<?php
return array(
    'beginYear'=>2011,
    'ver'=>'1.0.0', // R1
    'releaseDate'=>mktime(0, 0, 0, 8, 22, 2011), // month day year
    'rootAdmin'=>array('Harry'), // Username of Super Root account, have full access.
    'adminEmail'=>'admin@tramtuoi.com',
    'wwwRedirect'=>false,
    'schedulerDebug'=>$_SERVER['REMOTE_ADDR']=='127.0.0.1'?true:false,
    'langSystem'=>true,
    
    /* account */
    'disableAccountRegistration'=>false,
    'disableExtLogin'=>false,    
    
    'settings'=>array(
        'timeKeepUserLog'=>3600*24*30*1, // 1 months
        'timeKeepTaskLog'=>3600*24*3, // 3 days
        'smallPageSize'=>10,
        'midPageSize'=>25,
        'bigPageSize'=>50,
    ),
    
    'roleSettings'=>array(

    ),
    
    'google'=>array(
        'cse'=>array('cx'=>''),
    ),
    
    'facebook'=>array(
        'fbUrl'=>'facebook.com',
        'fbAppId'=>'',
        'fbAPI'=>'',
        'fbSecret'=>'',
        'page'=>'',
    ),
    
    'twitter'=>array(
        'consumerKey'=>'',
        'consumerSecret'=>'',
        'oauthToken'=>'',
        'oauthTokenSecret'=>'',
    ),
 

    
    'captcha'=>array(
        'foreColor'=>0x4C99C5,
        'maxLength'=>'5',
        'minLength'=>'4',
        'height'=>80,
        'width'=>120,
    ),
    
    'sliderImage'=>array(
        'smallThumbWidth'=>80, 'smallThumbHeight'=>24,
        'mediumThumbWidth'=>120, 'mediumThumbHeight'=>35,
        'bigThumbWidth'=>160, 'bigThumbHeight'=>47,
        'photoWidth'=>980, 'photoHeight'=>289
        ),    
   
);