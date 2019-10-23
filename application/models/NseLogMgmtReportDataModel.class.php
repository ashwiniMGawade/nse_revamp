<?php

class NseLogMgmtReportDataModel extends Model{
  
    public function getLinuxChecks($serverName = array(),  $day = '') {
        $sql = "SELECT if(nselogmanagementdata.nselogmanagementreportdata.status = 'started','Failure','Success') as status, count(*) as count FROM nselogmanagementdata.nselogmanagementreportdata where nselogmanagementdata.nselogmanagementreportdata.servertype = 'Unix' ";

        if(!empty($serverName)) {
            $sql .= " and ( ";
            foreach($serverName as $name) {
                $sql .= "LOWER(nselogmanagementdata.nselogmanagementreportdata.server) = LOWER('".$name."') or ";
            }     
            $sql .= " 1 ) ";       
        } 

        if($day) {
            $sql .= " and nselogmanagementdata.nselogmanagementreportdata.startdate >= ( CURDATE() - INTERVAL ".$day." DAY )";
        }
        $sql .= " GROUP BY nselogmanagementdata.nselogmanagementreportdata.status";
        
        $linuxchecks = $this->db->getAll($sql);

        return $linuxchecks;
    }

}