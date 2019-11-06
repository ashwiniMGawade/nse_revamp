<?php

class LinuxCheckModel extends Model{

    public function getLinuxChecks($serverName = array(), $day = '') {
        $sql = "SELECT nselogmanagement.unixcheck.status as status, count(*) as count FROM nselogmanagement.unixcheck WHERE 1";

        if(!empty($serverName)) {
            $sql .= " and ( ";
            foreach($serverName as $name) {
                $sql .= " LOWER(nselogmanagement.unixcheck.servername)= LOWER('".$name."') or ";
            }
            $sql .= " 1 ) ";     
        }
        
        if($day) {
            $sql .= " and nselogmanagement.unixcheck.time >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " group by nselogmanagement.unixcheck.status";

        $winchecks = $this->db->getAll($sql);

        return $winchecks;
    }

}