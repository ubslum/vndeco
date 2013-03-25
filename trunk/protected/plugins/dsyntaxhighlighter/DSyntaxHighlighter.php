<?php

/**
 * DSyntaxHighlighter Class
 * @author Gia Duy (admin@giaduy.info)
 */
class DSyntaxHighlighter extends CWidget {
    
    public $scriptUrl;
    //put your code here
    public function init() {
        parent::init();
        
        $this->scriptUrl = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets', false, -1, YII_DEBUG);
        $this->registerClientScript();
    }
    
    protected function registerClientScript(){
        $cs = Yii::app()->getClientScript();
        
        /* core */
        $cs->registerScriptFile($this->scriptUrl . '/scripts/shCore.js');
        $cs->registerScriptFile($this->scriptUrl . '/scripts/shAutoloader.js');
        /* Brush */
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushAS3.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushAppleScript.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushBash.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushCSharp.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushColdFusion.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushCpp.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushCss.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushDelphi.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushDiff.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushErlang.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushGroovy.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushJScript.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushJava.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushJavaFX.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushPerl.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushPhp.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushPlain.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushPowerShell.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushPython.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushRuby.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushSass.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushScala.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushSql.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushVb.js');
//        $cs->registerScriptFile($this->scriptUrl . '/scripts/shBrushXml.js');
        /* CSS */
        $cs->registerCssFile($this->scriptUrl . '/styles/shCoreDefault.css');
        /* call */
        $script=<<<EOB
function path()
{
  var args = arguments, result = [];
  for(var i = 0; i < args.length; i++)result.push(args[i].replace('@', '{$this->scriptUrl}/scripts/'));
  return result;
};
 
SyntaxHighlighter.autoloader.apply(null, path(
  'applescript            @shBrushAppleScript.js',
  'actionscript3 as3      @shBrushAS3.js',
  'bash shell             @shBrushBash.js',
  'coldfusion cf          @shBrushColdFusion.js',
  'cpp c                  @shBrushCpp.js',
  'c# c-sharp csharp      @shBrushCSharp.js',
  'css                    @shBrushCss.js',
  'delphi pascal          @shBrushDelphi.js',
  'diff patch pas         @shBrushDiff.js',
  'erl erlang             @shBrushErlang.js',
  'groovy                 @shBrushGroovy.js',
  'java                   @shBrushJava.js',
  'jfx javafx             @shBrushJavaFX.js',
  'js jscript javascript  @shBrushJScript.js',
  'perl pl                @shBrushPerl.js',
  'php                    @shBrushPhp.js',
  'text plain             @shBrushPlain.js',
  'py python              @shBrushPython.js',
  'ruby rails ror rb      @shBrushRuby.js',
  'sass scss              @shBrushSass.js',
  'scala                  @shBrushScala.js',
  'sql                    @shBrushSql.js',
  'vb vbnet               @shBrushVb.js',
  'xml xhtml xslt html    @shBrushXml.js'
));
SyntaxHighlighter.all();
EOB;
        $cs->registerScript('DSyntaxHighlighter', $script, CClientScript::POS_READY);
        
    }
}