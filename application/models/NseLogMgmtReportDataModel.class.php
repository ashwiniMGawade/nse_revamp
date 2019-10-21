<?php

class NseLogMgmtReportDataModel extends Model{
  
    public function getLinuxChecks($serverName = '',  $day) {
        $sql = "SELECT if(nselogmanagementdata.nselogmanagementreportdata.status = 'started','Failure','Success') as status, count(*) as count FROM nselogmanagementdata.nselogmanagementreportdata where nselogmanagementdata.nselogmanagementreportdata.servertype = 'Unix' ";

        if($serverName != '') {
            $sql .= "and LOWER(nselogmanagementdata.nselogmanagementreportdata.server) = LOWER('".$serverName."')";
        } 

        if($day) {
            $sql .= " and nselogmanagementdata.nselogmanagementreportdata.startdate >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }
        $sql .= " GROUP BY nselogmanagementdata.nselogmanagementreportdata.status";
        
        $linuxchecks = $this->db->getAll($sql);

        return $linuxchecks;
    }

}