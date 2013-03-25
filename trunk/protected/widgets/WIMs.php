<?php
/**
 * WIMs
 * @author Gia Duy (admin@giaduy.info)
 */
class WIMs extends CWidget {

    

    public function run() {
        $yahooIds=array('giaduyonline', 'cherub.harry');
?>
<center>
<?php foreach($yahooIds as $id):?>
    <a href="ymsgr:sendIM?<?php echo $id;?>" style="padding: 0 5px 0 5px;"><img src="http://opi.yahoo.com/online?u=<?php echo $id;?>&amp;m=g&amp;t=14" alt="Hỗ Trợ Online" border="0" /></a>
<?php endforeach;?>
</center>
<?php
    }
}