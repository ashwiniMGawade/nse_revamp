<?php

class WindowsCheckModel extends Model{

    public function getWindowsChecks($serverName = '', $day = '') {
        $sql = "SELECT windowscopycheckone.windows_check.status as status, count(*) as count FROM windowscopycheckone.windows_check WHERE 1";
        if($serverName != '') {
            $sql .= " and LOWER(windowscopycheckone.windows_check.servername)= LOWER('".$serverName."') ";
        }
        
        if($day) {
            $sql .= " and windowscopycheckone.windows_check.dateandtime >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " group by windowscopycheckone.windows_check.status";

        $winchecks = $this->db->getAll($sql);

        return $winchecks;
    }

}