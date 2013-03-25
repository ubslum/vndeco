<?php

/**
 * DeleteOldUserLog Class
 * @author Gia Duy (admin@giaduy.info)
 */
class DeleteOldUserLog {

    public function run() {
        set_time_limit(0);
        $result=$this->deleteLog();
        return $result;
    }

    protected function deleteLog() {
        $deleteTime=time()-Yii::app()->params['settings']['timeKeepUserLog'];
        
        $cri = new CDbCriteria();
        $cri->condition = 'time<=:deleteTime';
        $cri->params=array(':deleteTime'=>$deleteTime);
        
        $rowsDeleted=UserLog::model()->deleteAll($cri);
        
        return $rowsDeleted.' rows deleted';
    }
}
