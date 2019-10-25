<?php

class LinuxCopyModel extends Model{

    public function getLinuxCopies($serverName = array(), $day = '') {
        $sql = "SELECT nselogmanagement.unixlog.status as status, count(*) as count FROM nselogmanagement.unixlog  where 1 ";

        if(!empty($serverName)) {
            $sql .= " and ( ";
            foreach($serverName as $name) {
                $sql .= " LOWER(nselogmanagement.unixlog.server) = LOWER('".$name."') or ";
            }
            $sql .= " 1 ) ";     
        }

        if($day) {
            $sql .= " and nselogmanagement.unixlog.startdate >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " GROUP BY nselogmanagement.unixlog.status";
        $wincopies = $this->db->getAll($sql);

        return $wincopies;
    }

}