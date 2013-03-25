<?php

/**
 * DeleteTaskLog Class
 * @author Gia Duy (admin@giaduy.info)
 */
class DeleteTaskLog {

    public function run() {
        set_time_limit(0);
        $result=$this->deleteLog();
        return $result;
    }

    protected function deleteLog() {
        $deleteTime=time()-Yii::app()->params['settings']['timeKeepTaskLog'];
        
        $cri = new CDbCriteria();
        $cri->condition = 'date_run<=:deleteTime';
        $cri->params=array(':deleteTime'=>$deleteTime);
        
        $rowsDeleted=SchedulerLog::model()->deleteAll($cri);
        
        return $rowsDeleted.' rows deleted';
    }
}
