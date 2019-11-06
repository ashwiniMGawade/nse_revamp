<?php

class WindowsCheckModel extends Model{

    public function getWindowsChecks($serverName = array(), $day = '') {
        $sql = "SELECT nselogmanagement.windowscheck.status as status, count(*) as count FROM nselogmanagement.windowscheck WHERE 1";

        if(!empty($serverName)) {
            $sql .= " and ( ";
            foreach($serverName as $name) {
                $sql .= " LOWER(nselogmanagement.windowscheck.servername)= LOWER('".$name."') or ";
            }
            $sql .= " 1 ) ";     
        }
        
        if($day) {
            $sql .= " and nselogmanagement.windowscheck.time >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " group by nselogmanagement.windowscheck.status";

        $winchecks = $this->db->getAll($sql);

        return $winchecks;
    }

}