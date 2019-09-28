<?php

class WindowsCheckModel extends Model{

    public function getWindowsChecks($serverName = '') {
        if($serverName != '') {
            $sql = "SELECT windowscopycheckone.windows_check.status as status, count(*) as count FROM windowscopycheckone.windows_check WHERE  LOWER(windowscopycheckone.windows_check.servername)= LOWER('".$serverName."') group by windowscopycheckone.windows_check.status";
        } else {
            $sql = "SELECT windowscopycheckone.windows_check.status as status, count(*) as count FROM windowscopycheckone.windows_check group by windowscopycheckone.windows_check.status";
        }      

        $winchecks = $this->db->getAll($sql);

        return $winchecks;
    }

}