<?php

class BarcodeController extends MyController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform all actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Code 39
     */
    public function actionCode39() {
        if (isset($_GET['code'])) {
            $path = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . '3rdparty' . DIRECTORY_SEPARATOR . 'barcodegen';

            require($path . '/class/BCGFont.php');
            require($path . '/class/BCGColor.php');
            require($path . '/class/BCGDrawing.php');
            include($path . '/class/BCGcode39.barcode.php');
            $color_black = new BCGColor(0, 0, 0);
            $color_white = new BCGColor(255, 255, 255);

            /* config */            
            $fontSize=isset($_GET['fontSize'])?$_GET['fontSize']:9;
            $resolution=isset($_GET['resolution'])?$_GET['resolution']:1;
            $thickness=isset($_GET['thickness'])?$_GET['thickness']:20;

            $font = new BCGFont($path . '/class/font/Arial.ttf', $fontSize);
            $font=0;
            if(isset($_GET['font'])) $font=$_GET['font'];

            $code = new BCGcode39();
            $code->setScale($resolution); // Resolution
            $code->setThickness($thickness); // Thickness
            $code->setForegroundColor($color_black); // Color of bars
            $code->setBackgroundColor($color_white); // Color of spaces
            $code->setFont($font); // Font (or 0)
            $code->parse($_GET['code']); // Text

            $drawing = new BCGDrawing('', $color_white);
            $drawing->setBarcode($code);
            $drawing->draw();

            header('Content-Type: image/png');

            $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
        }
    }

}