<?php
require_once(Yii::app()->basePath.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'3rdparty'.DIRECTORY_SEPARATOR.'phpthumb'.DIRECTORY_SEPARATOR.'ThumbLib.inc.php');
/**
 * ImageThumb
 * @example
 * <pre>
 * try
 * {
 *      $thumb = ImageThumb::create('/path/to/image.jpg');
 * }
 * catch (Exception $e)
 * {
 *      // handle error here however you'd like
 * }
 *
 * $thumb->resize(100, 100);
 * $thumb->resizePercent(50);
 * $thumb->adaptiveResize(175, 175);
 * $thumb->cropFromCenter(200, 100);
 * $thumb->cropFromCenter(200);
 * $thumb->crop(100, 100, 300, 200);
 * $thumb->save('/path/to/new_image.jpg');
 * </pre>
 * @author Gia Duy
 */
class ImageThumb extends PhpThumbFactory {

}