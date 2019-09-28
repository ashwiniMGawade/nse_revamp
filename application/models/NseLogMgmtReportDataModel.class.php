<?php

class NseLogMgmtReportDataModel extends Model{
  
    public function getLinuxChecks() {
        $sql = "SELECT if(nselogmanagementdata.nselogmanagementreportdata.status = 'started','Failure','Success') as status, count(*) as count FROM nselogmanagementdata.nselogmanagementreportdata where nselogmanagementdata.nselogmanagementreportdata.servertype = 'Unix' GROUP BY nselogmanagementdata.nselogmanagementreportdata.status";

        $linuxchecks = $this->db->getAll($sql);

        return $linuxchecks;
    }

}