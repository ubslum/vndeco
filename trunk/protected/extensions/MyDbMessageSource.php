<?php

/**
 * MyDbMessageSource
 * Category group: CommonMessage, HttpException, breadcrumbs
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class MyDbMessageSource extends CDbMessageSource {
    
    public $sourceMessageTable = '{{message_source}}';
    public $translatedMessageTable = '{{message_translated}}';

    /**
     * insert Missing Translation
     * @param object $event
     */
    public function insertMissingTranslation($event) {
        /* Find source message */
        $criteria = new CDbCriteria;
        $criteria->condition = 'category=:category AND message=:message';
        $criteria->params = array(':category'=>$event->category, ':message'=>$event->message);
        $messageSource = MessageSource::model()->find($criteria);

        /* Not found */
        if (!$messageSource) {
            $messageSource = new MessageSource();
            $messageSource->category = $event->category;
            $messageSource->message = $event->message;
            $messageSource->save();
        }

        $messageTranslated = MessageTranslated::model()->findByPk(array('id'=>$messageSource->id, 'language'=>$event->language));
        if (!$messageTranslated) {
            $messageTranslated = new MessageTranslated();
            $messageTranslated->id = $messageSource->id;
            $messageTranslated->language = $event->language;
            $messageTranslated->translation = $event->message;
            $messageTranslated->save();
        }
    }
}
