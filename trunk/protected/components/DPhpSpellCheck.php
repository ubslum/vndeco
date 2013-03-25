<?php

require_once(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . '3rdparty' . DIRECTORY_SEPARATOR . 'phpspellcheck' . DIRECTORY_SEPARATOR . 'core'.DIRECTORY_SEPARATOR. 'php'. DIRECTORY_SEPARATOR . 'engine.php');

class DPhpSpellCheck extends PHPSpellCheck {

    public function __construct() {
        $this->LicenceKey = "TRIAL";


        //BASIC SETTINGS
        $this->IgnoreAllCaps = false;
        $this->IgnoreNumeric = false;
        $this->CaseSensitive = true;


        // Set up the file path to the (.dic) dictionaries folder
        $this->DictionaryPath = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . '3rdparty' . DIRECTORY_SEPARATOR . 'phpspellcheck' . DIRECTORY_SEPARATOR .'dictionaries'.DIRECTORY_SEPARATOR;

        # Sets the tollerance of the spellchecker to 'unlikely' suggestions. 0=intollerant ... 10=very tollerant  
        $this->SuggestionTollerance = 1;

        # Loads a dictionary - you can load more than one at the same time */
        $this->LoadDictionary("English (International)");
        #Add vocabulary to the spellchecer from a text file loaded from the DictionaryPath*/
        $this->LoadCustomDictionary("custom.txt");


        /* Alternative methods to load vocabulary
          $this -> LoadCustomDictionaryFromURL( $URL );
          $this ->AddCustomDictionaryFromArray(array("popup","nonsensee"));
          /*

          /* Ban a list of words which will never be alloed as correct spellings.  Ths is great for filtering profanicy. */
        $this->LoadCustomBannedWords("language-rules/banned-words.txt");
        /*
          You can also add banned words from an array which you could easily populate from an SQL query
          //$this -> AddBannedWords(array("primary"));
         */

        /* Load a lost of Enforced Corrections from a file.  This allows you to enforce a spelling suggestion for a specific word or acronym. */
        $this->LoadEnforcedCorrections("language-rules/enforced-corrections.txt");

        /* Load a list of common typing mistakes to fine tune the suggestion performance. */
        $this->LoadCommonTypos("language-rules/common-mistakes.txt");
    }

}