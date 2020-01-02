<?php

class LinuxCopyModel extends Model{

    public function getLinuxCopies($serverName = array(), $day = '') {
        $sql = "SELECT nselogmanagement.unixlog.status as status, count(*) as count FROM nselogmanagement.unixlog  where 1 ";

        if(!empty($serverName)) {
            $sql .= " and ( ";
            foreach($serverName as $name) {
                $sql .= " LOWER(nselogmanagement.unixlog.servername) = LOWER('".$name."') or ";
            }
            $sql .= " 0 ) ";     
        }

        if($day) {
            $sql .= " and nselogmanagement.unixlog.starttime >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " GROUP BY nselogmanagement.unixlog.status";
        $wincopies = $this->db->getAll($sql);

        return $wincopies;
    }

    public function getLinuxServerStatus($date = '') {
        $sql = "SELECT serverlist.servername, date(unixlog.starttime), count(*) FROM nselogmanagement.unixlog right join nselogmanagement.serverlist
        on nselogmanagement.serverlist.servername = nselogmanagement.unixlog.servername
        where nselogmanagement.serverlist.flag = 'Unix' and nselogmanagement.serverlist.logcollection = 'Enabled' ";

     
        if($date) {
            $sqlDate = "date('$date')";
            if( $date == "today") {
                $sqlDate = "date(CURDATE() - INTERVAL 1 DAY)";
            }
            $sql .= " and date(nselogmanagement.unixlog.starttime) = $sqlDate";
        }

        $sql .= "  group by serverlist.servername;";

        // print_R($sql);
       
        $wincopies = $this->db->getAll($sql);

        return $wincopies;
    }
}