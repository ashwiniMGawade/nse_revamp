<?php

// application/models/UserModel.class.php

class WindowsCopyModel extends Model{

    public function getWindowsCopies($serverName = array(), $day = '') {
        $sql = "SELECT nselogmanagement.windowslog.status as status, count(*) as count FROM nselogmanagement.windowslog  where 1 ";

        if(!empty($serverName)) {
            $sql .= " and ( ";
            foreach($serverName as $name) {
                $sql .= " LOWER(nselogmanagement.windowslog.servername) = LOWER('".$name."') or ";
            }
            $sql .= " 0 ) ";     
        }

        if($day) {
            $sql .= " and nselogmanagement.windowslog.starttime >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " GROUP BY nselogmanagement.windowslog.status";

        $wincopies = $this->db->getAll($sql);

        return $wincopies;
    }


    public function getWindowsServerStatus($date = '') {
        $sql = "SELECT serverlist.servername, date(windowslog.starttime), count(*) FROM nselogmanagement.windowslog right join nselogmanagement.serverlist
        on nselogmanagement.serverlist.servername = nselogmanagement.windowslog.servername
        where nselogmanagement.serverlist.flag = 'Windows' and nselogmanagement.serverlist.logcollection = 'Enabled' ";

     
        if($date) {
            $sqlDate = "date('$date')";
            if( $date == "today") {
                $date =  date('Y-m-d',strtotime("-1 days"));
                $sqlDate = "date('$date')";
            }
            $sql .= " and date(nselogmanagement.windowslog.starttime) = $sqlDate";
        }

        $sql .= "  group by serverlist.servername;";

        // print_R($sql);
       
        $wincopies = $this->db->getAll($sql);

        return $wincopies;
    }

}