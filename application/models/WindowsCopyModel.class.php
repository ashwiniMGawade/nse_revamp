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
            $sql .= " 1 ) ";     
        }

        if($day) {
            $sql .= " and nselogmanagement.windowslog.startdate >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " GROUP BY nselogmanagement.windowslog.status";
        $wincopies = $this->db->getAll($sql);

        return $wincopies;
    }

}