<?php

/**
 * WFacebookLikeBox Class
 * @author Gia Duy (admin@giaduy.info)
 */
class WFacebookLikeBox extends CWidget {

    public $params = array();

    public function run() {
?>
<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="<?php echo Yii::app()->params['facebook']['page'];?>" width="300" show_faces="true" border_color="#ffffff" stream="false" header="false"></fb:like-box>
<?php
    }

}