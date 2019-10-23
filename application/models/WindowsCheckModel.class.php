<?php

class WindowsCheckModel extends Model{

    public function getWindowsChecks($serverName = array(), $day = '') {
        $sql = "SELECT windowscopycheckone.windows_check.status as status, count(*) as count FROM windowscopycheckone.windows_check WHERE 1";

        if(!empty($serverName)) {
            $sql .= " and ( ";
            foreach($serverName as $name) {
                $sql .= " LOWER(windowscopycheckone.windows_check.servername)= LOWER('".$name."') or ";
            }
            $sql .= " 1 ) ";     
        }
        
        if($day) {
            $sql .= " and windowscopycheckone.windows_check.dateandtime >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " group by windowscopycheckone.windows_check.status";

        $winchecks = $this->db->getAll($sql);

        return $winchecks;
    }

}