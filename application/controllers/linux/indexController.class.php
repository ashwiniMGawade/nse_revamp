<?php

// application/controllers/home/IndexController.class.php

require "application/controllers/BaseController.class.php";
require "framework/helpers/paginate.php";
require "framework/helpers/functions.php";

class IndexController extends BaseController{

    public function indexAction() {
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
            $where = 'LOWER(server) =LOWER("'. $serverName.'") and ';
        }

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $status = urldecode($_GET['status']);
            $where .= 'LOWER(status) =LOWER("'.$status.'") and ';
        }

        $fieldName ='startdate';
        if (isset($_GET['startDate']) && $_GET['startDate'] != '' && isset($_GET['endDate']) && $_GET['endDate'] != '') {
            $startdate = urldecode($_GET['startDate']);
            $enddate = urldecode($_GET['endDate']);            
            $where .= '(DATE('.$fieldName.') between "'.$startdate. '" and "'.$enddate.'") and ';
        } else {
            if (isset($_GET['startDate']) && $_GET['startDate'] != '') {
                $startdate = urldecode($_GET['startDate']);
                $where .= 'DATE('.$fieldName.') ="'.$startdate.'" and ';
            }
    
            if (isset($_GET['endDate']) && $_GET['endDate'] != '') {
                $enddate = urldecode($_GET['endDate']);
                $where .= 'DATE('.$fieldName.') ="'.$enddate.'" and ';
            }    
        } 
        $where .= " 1 ";
        return $where;
    }


    public function copyChecksAction() {
        $where = $this->getConditionsData();       
        $validStatusToAssign = ["success", "completed", "started", "in-progress", "failed"];
        $linuxCheckModel = new NseLogMgmtReportDataModel("nselogmanagementdata.nselogmanagementreportdata");

        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $paginateOptions = paginate( $linuxCheckModel, $rowsperpage, $where);

        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        $sortingInfo = $this->getSortinginfo();

        $checks = $linuxCheckModel->pageRows($offset, $rowsperpage, $where, $sortingInfo['order_by'], $sortingInfo['sort']);

        $url = $this->getUrl();
      
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
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $serverName = urldecode($_GET['name']);
            $breadcrumbs[] =  (object) [
                'title' => $serverName,
                "isActive" => false,
                "link" => "index.php?p=linux&name=".$serverName
            ];
        }
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
        $sortingInfo = $this->getSortinginfo(); 

        $linuxCheckModel = new NseLogMgmtReportDataModel("nselogmanagementdata.nselogmanagementreportdata");

        $data = $linuxCheckModel->pageRows(0, 1000, $where, $sortingInfo['order_by'], $sortingInfo['sort']);

        download_send_headers("data_export_linux_" . date("Y-m-d") . ".csv");
        echo array2csv($data);
        die();
    
    }

    public function getDataAction() {    
        $linuxCheckModel = new NseLogMgmtReportDataModel("nselogmanagementdata.nselogmanagementreportdata");
        $serverName = '';
        if (isset($_POST['name']) && $_POST['name'] != '') {      
            $serverName = urldecode($_POST['name']);
        }

        if (isset($_POST['day']) && $_POST['day'] != '') {      
            $day = urldecode($_POST['day']);
        }
       
        $checks = $linuxCheckModel->getLinuxChecks($serverName, $day);

        $data = array();
        $data[0]= array("Status", "Count");

        foreach ($checks as $row) {  
            $a = array();
            array_push($a, trim($row["status"], " \r."));
            array_push($a, intval($row["count"]));
            array_push($data, $a);
        };

        echo json_encode($data);
        exit;
    }
}