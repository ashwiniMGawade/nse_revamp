<?php

// application/controllers/home/IndexController.class.php

require "application/controllers/BaseController.class.php";
require "framework/helpers/paginate.php";

class IndexController extends BaseController{

    public function indexAction() {
        
        $linuxCheckModel = new NseLogMgmtReportDataModel("nselogmanagementdata.nselogmanagementreportdata");
        $checks = $linuxCheckModel->getLinuxChecks();

        $linuxServerModel = new LinuxServerModel('nselogserverunix.unixserverinput');
        $servers = $linuxServerModel->pageRows(0, 10);
        $showServers = true;
        $serverType = "linux";

        $isMain = true;
        $breadcrumb = array();
        $breadcrumbs[] =  (object) [
            'title' => 'Home',
            'link' =>  "index.php",
            "isActive" => false
          ];
        $breadcrumbs[] =  (object) [
            'title' => 'Linux',
            "isActive" => true
        ];
        $lnavElement = array("element" => "Linux Server", "link"=> "index.php?p=linux");

        $pageContent = CURR_VIEW_PATH . "linuxServer.php";

        include VIEW_PATH."template.php";
    }

    public function searchAction(){
        $where = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = urldecode($_GET['search']);
            $where = 'nselogserverunix.unixserverinput.servername like "%'.$search.'%"';
         }
        $linuxServerModel = new LinuxServerModel('nselogserverunix.unixserverinput');
        $servers = $linuxServerModel->pageRows(0, 1000, $where);
        echo json_encode($servers);

    }

    
    private function getConditionsData() {
        $where = '';
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $serverName = urldecode($_GET['name']);
            $where = 'LOWER(servername) =LOWER("'. $serverName.'") and ';
        }

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $status = urldecode($_GET['status']);
            $where .= 'LOWER(status) =LOWER("'.$status.'") and ';
        }

        if (isset($_GET['startDate']) && $_GET['startDate'] != '') {
            $startdate = urldecode($_GET['startDate']);
            $where .= 'DATE(startdate) ="'.$startdate.'" and ';
        }

        if (isset($_GET['endDate']) && $_GET['endDate'] != '') {
            $enddate = urldecode($_GET['endDate']);
            $where .= 'DATE(enddate) ="'.$enddate.'" and ';
        }

        $where .= " 1 ";
        return $where;
    }


    public function copyChecksAction() {
        $where = $this->getConditionsData();       

        $linuxCheckModel = new NseLogMgmtReportDataModel("nselogmanagementdata.nselogmanagementreportdata");

        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $paginateOptions = paginate( $linuxCheckModel, $rowsperpage, $where);

        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];

        $checks = $linuxCheckModel->pageRows($offset, $rowsperpage, $where);
      
        $showServers = true;
        $serverType = "linux";      

        $isMain = true;
        $breadcrumb = array();
        $breadcrumbs[] =  (object) [
            'title' => 'Home',
            'link' =>  "index.php",
            "isActive" => false
          ];
        $breadcrumbs[] =  (object) [
            'title' => 'Linux',
            "isActive" => false, 
            "link" => "index.php?p=linux"
        ];
        $breadcrumbs[] =  (object) [
            'title' => 'Copy and Check',
            "isActive" => true
        ];
        $lnavElement = array("element" => "Linux Server", "link"=> "index.php?p=linux");

        $pageContent = CURR_VIEW_PATH . "linuxCopiesChecks.php";

        include VIEW_PATH."template.php";
    }

    public function serverAction() {
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $serverName = urldecode($_GET['name']);
         } else {
            // default page num
           return $this->linuxAction();
        }
        $linuxCheckModel = new NseLogMgmtReportDataModel("nselogmanagementdata.nselogmanagementreportdata");
        $checks = $linuxCheckModel->getLinuxChecks();

        $showServers = true;
        $serverType = "linux";

        $isMain = true;
        $breadcrumb = array();
        $breadcrumbs[] =  (object) [
            'title' => 'Home',
            'link' =>  "index.php",
            "isActive" => false
          ];
        $breadcrumbs[] =  (object) [
            'title' => 'Linux',
            "isActive" => false,
            'link' => "index.php?p=linux"
        ];

        $breadcrumbs[] =  (object) [
            'title' => $serverName,
            "isActive" => true
        ];
        $lnavElement = array("element" => "Linux Server", "link"=> "index.php?p=linux");
        $pageContent = CURR_VIEW_PATH . "linuxServer.php";

        include VIEW_PATH."template.php";
    }

    
    public function downloadAction(){
        $where = $this->getConditionsData();      

        $linuxCheckModel = new NseLogMgmtReportDataModel("nselogmanagementdata.nselogmanagementreportdata");

        $data = $linuxCheckModel->pageRows(0, 1000, $where);

        download_send_headers("data_export_" . date("Y-m-d") . ".csv");
        echo array2csv($data);
        die();
    
    }
}