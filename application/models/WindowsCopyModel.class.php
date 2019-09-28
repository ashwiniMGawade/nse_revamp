<?php

// application/models/UserModel.class.php

class WindowsCopyModel extends Model{

    public function getWindowsCopies($serverName = '') {
        if($serverName != '') {
            $sql = "SELECT windowscopycheck.windows_copy.status as status, count(*) as count FROM windowscopycheck.windows_copy  where  LOWER(windowscopycheck.windows_copy.servername) = LOWER('".$serverName."') GROUP BY windowscopycheck.windows_copy.status";
        } else {
            $sql = "SELECT windowscopycheck.windows_copy.status as status, count(*) as count FROM windowscopycheck.windows_copy GROUP BY windowscopycheck.windows_copy.status";
        }
        $wincopies = $this->db->getAll($sql);

        return $wincopies;
    }

}