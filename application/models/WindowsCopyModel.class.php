<?php

// application/models/UserModel.class.php

class WindowsCopyModel extends Model{

    public function getWindowsCopies($serverName = '', $day) {
        $sql = "SELECT windowscopycheck.windows_copy.status as status, count(*) as count FROM windowscopycheck.windows_copy  where 1 ";

        if($serverName != '') {
            $sql .= " and LOWER(windowscopycheck.windows_copy.servername) = LOWER('".$serverName."') ";
        } 

        if($day) {
            $sql .= " and windowscopycheck.windows_copy.startdate >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " GROUP BY windowscopycheck.windows_copy.status";
        $wincopies = $this->db->getAll($sql);

        return $wincopies;
    }

}