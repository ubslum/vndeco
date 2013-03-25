<?php

/**
 * PNivoSlider Class
 * @author Gia Duy (admin@giaduy.info)
 * @link http://nivo.dev7studios.com/support/jquery-plugin-usage/
 */
class PNivoSlider extends CWidget {

    public $effect = 'random'; // Specify sets like: sliceDown,sliceDownLeft,sliceUp,sliceUpLeft,sliceUpDown,sliceUpDownLeft,fold,fade,random,slideInRight,slideInLeft,boxRandom,boxRain,boxRainReverse,boxRainGrow,boxRainGrowReverse
    public $slices = 15; // For slice animations
    public $boxCols = 8; // For box animations
    public $boxRows = 4; // For box animations
    public $animSpeed = 500; // Slide transition speed
    public $pauseTime = 3000; // How long each slide will show
    public $startSlide = 0; // Set starting Slide (0 index)
    public $directionNav = true; // Next & Prev navigation
    public $controlNav = true; // 1;2;3... navigation
    public $controlNavThumbs = false; // Use thumbnails for Control Nav
    public $pauseOnHover = true; // Stop animation while hovering
    public $manualAdvance = false; // Force manual transitions
    public $prevText = 'Prev'; // Prev directionNav text
    public $nextText = 'Next'; // Next directionNav text
    public $randomStart = false; // Start on a random slide
    public $beforeChange = 'function(){}'; // Triggers before a slide transition
    public $afterChange = 'function(){}'; // Triggers after a slide transition
    public $slideshowEnd = 'function(){}'; // Triggers after all slides have been shown
    public $lastSlide = 'function(){}'; // Triggers when last slide is shown
    public $afterLoad = 'function(){}'; // Triggers when slider has loaded    
    /* main */
    public $images = array();
    public $theme = 'default'; // default, bar, dark, light

    public function init() {
        parent::init();
        $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', false, -1, YII_DEBUG);
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($assets . '/themes/bar/bar.css');
        $cs->registerCssFile($assets . '/themes/dark/dark.css');
        $cs->registerCssFile($assets . '/themes/default/default.css');
        $cs->registerCssFile($assets . '/themes/light/light.css');
        $cs->registerCssFile($assets . '/nivo-slider.css');
        $cs->registerScriptFile($assets . '/jquery.nivo.slider.pack.js');
        $script = '$("#slider").nivoSlider({effect: "' . $this->effect . '",slices: ' . $this->slices . ',boxCols: ' . $this->boxCols . ',boxRows: ' . $this->boxRows . ',animSpeed: ' . $this->animSpeed . ',pauseTime: ' . $this->pauseTime . ',startSlide: ' . $this->startSlide . ',directionNav: "' . $this->directionNav . '",controlNav: "' . $this->controlNav . '",controlNavThumbs: "' . $this->controlNavThumbs . '",pauseOnHover: "' . $this->pauseOnHover . '",manualAdvance: "' . $this->manualAdvance . '",prevText: "' . $this->prevText . '",nextText: "' . $this->nextText . '",randomStart: "' . $this->randomStart . '",beforeChange: ' . $this->beforeChange . ',afterChange: ' . $this->afterChange . ',slideshowEnd: ' . $this->slideshowEnd . ',lastSlide: ' . $this->lastSlide . ',afterLoad: ' . $this->afterLoad . ',});';
        $cs->registerScript('nivo-slider', $script, CClientScript::POS_READY);
        /* load images from database if null */
        if (count($this->images) == 0) {
            $images = SliderImage::model()->findAll();
            if ($images){
                foreach ($images as $image) {
                    $this->images[]=array('src'=>Yii::app()->request->baseUrl . '/image.php?type=sliderImage&id=' . $image->id, 'data-thumb'=>Yii::app()->request->baseUrl . '/image.php?type=sliderThumb&size=medium&id=' . $image->id, 'url'=>null, 'title'=>$image->title, 'alt'=>$image->alt, 'data-transition'=>$image->data_transition);
                }
            }
        }
    }

    public function run() {
        ?>
        <div class="slider-wrapper theme-<?php echo $this->theme; ?>">
            <div id="slider" class="nivoSlider">
        <?php foreach ($this->images as $image): ?>
            <?php $img = CHtml::image($image['src'], $image['alt'], array('title' => $image['title'], 'data-thumb' => $image['data-thumb'], 'data-transition' => $image['data-transition'])); ?>
                    <?php if (isset($image['url'])): ?>
                        <?php echo CHtml::link($img, $image['url']); ?>
                    <?php else: ?>
                        <?php echo $img; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
                <?php
            }

        }