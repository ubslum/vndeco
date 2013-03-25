<?php

/**
 * UpdateUserLogCountry Class
 * @author Gia Duy (admin@giaduy.info)
 */
class UpdateUserLogCountry {

    public function run() {
        set_time_limit(0);
        $result=$this->updateCountry();
        return $result;
    }

    protected function updateCountry() {
        $cri=new CDbCriteria();
        $cri->condition='country IS NULL';
        $cri->limit=100;
        $rows=UserLog::model()->findAll($cri);
        
        foreach($rows as $row)
        {
            $row->country=Common::getCountryByIp($row->ip);
            $row->save();
        }
        
        return count($rows).' row(s) updated';
    }
}
