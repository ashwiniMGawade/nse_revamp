<?php

// application/models/UserModel.class.php

class WindowsCopyModel extends Model{

    public function getWindowsCopies($serverName = array(), $day = '') {
        $sql = "SELECT windowscopycheck.windows_copy.status as status, count(*) as count FROM windowscopycheck.windows_copy  where 1 ";

        if(!empty($serverName)) {
            $sql .= " and ( ";
            foreach($serverName as $name) {
                $sql .= " LOWER(windowscopycheck.windows_copy.servername) = LOWER('".$name."') or ";
            }
            $sql .= " 1 ) ";     
        }

        if($day) {
            $sql .= " and windowscopycheck.windows_copy.startdate >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }

        $sql .= " GROUP BY windowscopycheck.windows_copy.status";
        $wincopies = $this->db->getAll($sql);

        return $wincopies;
    }

}