<?php

/**
 * WSearchBox Class
 * @link http://www.greyneuron.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; greyneuron.com
 * @license http://www.greyneuron.com/code/license
 * GOOGLE API: ABQIAAAAHGKVe0LczOkiSofdqqZXOBRydh8qCKh2kYVPLxxloeIE9pze-xTfCFuv3byKx3AFvDVTCzveeKQ6Lg
 */
class WSearchBox extends CWidget {

    public function run() {
?>
<form action="<?php echo Common::generateHyperLink(Yii::app()->createUrl('site/search')); ?>" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="<?php echo Yii::app()->params['google']['cse']['cx'];?>" />
    <input type="hidden" name="cof" value="FORID:10" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="30" />
    <input type="submit" name="sa" value="" class="search-button" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.com.vn/cse/brand?form=cse-search-box&amp;lang=<?php echo Yii::app()->language;?>"></script>
<?php
    }

}