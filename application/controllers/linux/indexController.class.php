<?php

// application/controllers/home/IndexController.class.php

require "application/controllers/BaseController.class.php";
require "framework/helpers/paginate.php";
require "framework/helpers/functions.php";

class IndexController extends BaseController{

    public function indexAction() {
        $serverModel = new ServerModel('nselogmanagement.serverList');
        $where = 'nselogmanagement.serverlist.flag = "Unix"';
        $servers = $serverModel->pageRows(0, 10, $where);
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
        $where = 'nselogmanagement.serverlist.flag = "Unix"';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = urldecode($_GET['search']);
            $where .= 'and nselogmanagement.serverList.servername like "%'.$search.'%"';
         }
        $serverModel = new ServerModel('nselogmanagement.serverList');
        $servers = $serverModel->pageRows(0, 1000, $where);
        echo json_encode($servers);

    }

    
    private function getConditionsData() {
        $where = '';
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $fieldname = "server";
            if ($this->isChecks()) {
                $fieldname = "servername";
            }
            $where = '(';
            foreach($_GET['name'] as $servername) {
                $where .= 'LOWER('.$fieldname.') =LOWER("'. $servername.'") or ';
            }
            $where .= ' 0 ) and ';
        }

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $status = urldecode($_GET['status']);
            $where .= 'LOWER(status) =LOWER("'.$status.'") and ';
        }

       $datefieldName = ($this->isChecks() ? 'time': 'starttime');
        if (isset($_GET['startDate']) && $_GET['startDate'] != '' && isset($_GET['endDate']) && $_GET['endDate'] != '') {
            $startdate = urldecode($_GET['startDate']);
            $enddate = urldecode($_GET['endDate']);  
            $date = new DateTime($startdate);
            $startdate = $date->format("Y-m-d H:i:s");
            $date1 = new DateTime($enddate);
            $enddate = $date1->format("Y-m-d H:i:s");          
            $where .= '('.$datefieldName.' between "'.$startdate. '" and "'.$enddate.'") and ';
        } else {
            if (isset($_GET['startDate']) && $_GET['startDate'] != '') {
                $startdate = urldecode($_GET['startDate']);
                $date = new DateTime($startdate);
                $startdate = $date->format("Y-m-d H:i:s");
                $where .= $datefieldName.' >="'.$startdate.'" and ';
            }
    
            if (isset($_GET['endDate']) && $_GET['endDate'] != '') {
                $enddate = urldecode($_GET['endDate']);
                $date1 = new DateTime($enddate);
                $enddate = $date1->format("Y-m-d H:i:s");          
                $where .=$datefieldName.' <="'.$enddate.'" and ';
            }    
        } 
        $where .= " 1 ";
        return $where;
    }


    public function copiesAction() {
        $where = $this->getConditionsData();       
        $validStatusToAssign = ["success", "warning", "started", "in-progress", "failed"];
        $linuxCopyModel = new LinuxCopyModel("nselogmanagement.unixlog");

        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $paginateOptions = paginate( $linuxCopyModel, $rowsperpage, $where);

        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        $sortingInfo = $this->getSortinginfo();

        $where1 = 'nselogmanagement.serverlist.flag = "Unix"';
        $linuxServerModel = new ServerModel('nselogmanagement.serverlist');
        $servers = $linuxServerModel->pageRows(0, 2000, $where1);

        $checks = $linuxCopyModel->pageRows($offset, $rowsperpage, $where, $sortingInfo['order_by'], $sortingInfo['sort']);

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
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $serverName = implode(',', $_GET['name']);
            $link = "index.php?p=linux";
            foreach($_GET['name'] as $server_name) {
                $link .= "&name=".$server_name;
            }
            $breadcrumbs[] =  (object) [
                'title' => $serverName,
                "isActive" => false,
                "link" => $link
            ];
        }
        $breadcrumbs[] =  (object) [
            'title' => 'Copy',
            "isActive" => true
        ];

       
        $lnavElement = array("element" => "Linux Server", "link"=> "index.php?p=linux");

        $pageContent = CURR_VIEW_PATH . "linuxCopies.php";

        include VIEW_PATH."template.php";
    }

    public function checksAction() {
        $where = $this->getConditionsData();       
        $validStatusToAssign = ["success", "failed"];
        $linuxCheckModel = new LinuxCheckModel("nselogmanagement.unixcheck");

        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $paginateOptions = paginate( $linuxCheckModel, $rowsperpage, $where);

        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        $sortingInfo = $this->getSortinginfo();

        $where1 = 'nselogmanagement.serverlist.flag = "Unix"';
        $linuxServerModel = new ServerModel('nselogmanagement.serverlist');
        $servers = $linuxServerModel->pageRows(0, 2000, $where1);

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
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $serverName = implode(',', $_GET['name']);
            $link = "index.php?p=linux";
            foreach($_GET['name'] as $server_name) {
                $link .= "&name=".$server_name;
            }
            $breadcrumbs[] =  (object) [
                'title' => $serverName,
                "isActive" => false,
                "link" => $link
            ];
        }
        $breadcrumbs[] =  (object) [
            'title' => 'Check',
            "isActive" => true
        ];

       
        $lnavElement = array("element" => "Linux Server", "link"=> "index.php?p=linux");

        $pageContent = CURR_VIEW_PATH . "linuxChecks.php";

        include VIEW_PATH."template.php";
    }

    public function serverAction() {
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $serverName = $_GET['name'];
         } else {
            // default page num
           return $this->linuxAction();
        }
        $linuxCheckModel = new LinuxCheckModel("nselogmanagement.unixcheck");
        $checks = $linuxCheckModel->getLinuxChecks($serverName);

        $linuxCopyModel = new LinuxCopyModel("nselogmanagement.unixlog");
        $copies = $linuxCopyModel->getLinuxCopies($serverName);

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
            'title' => implode(',', $serverName),
            "isActive" => true
        ];
        $lnavElement = array("element" => "Linux Server", "link"=> "index.php?p=linux");
        $pageContent = CURR_VIEW_PATH . "linuxServer.php";

        include VIEW_PATH."template.php";
    }



    public function downloadAction(){
        $where = $this->getConditionsData();
        $model =  new LinuxCopyModel("nselogmanagement.unixlog");
        $sortingInfo = $this->getSortinginfo(); 
      
        if ($this->isChecks()) {
            $model =  new LinuxCheckModel("nselogmanagement.unixcheck");
        }
        $data = $model->pageRows(0, 1000, $where, $sortingInfo['order_by'], $sortingInfo['sort']);

        download_send_headers("data_export_windows_" . date("Y-m-d") . ".csv");
        echo array2csv($data);
        die();
    
    }

    
    private function isChecks() {
        if (ACTION == "checks") {
            return true;
        } else {
            if(ACTION == "download" && isset($_GET['param']) && $_GET['param']=="checks") {
                return true;
            }
        }
        return false;
    }

    public function getDataAction() {    
        $serverName = array();
        if (isset($_POST['name']) && !empty($_POST['name'])) {      
            $serverName = $_POST['name'];
        }
        $type = "copy"; 
        if (isset($_POST['type']) && $_POST['type'] != '') {      
            $type = urldecode($_POST['type']);
        } 
       
        $day = '';

        if (isset($_POST['day']) && $_POST['day'] != '') {      
            $day = urldecode($_POST['day']);
        }

        if ($type == "copy") {
            $model =  new LinuxCopyModel("nselogmanagement.unixlog");
            $results = $model->getLinuxCopies( $serverName, $day);
        } else {
            $model =  new LinuxCheckModel("nselogmanagement.unixcheck");
            $results = $model->getLinuxChecks( $serverName, $day);          
        }


        $data = array();
        $data[0]= array("Status", "Count");

        foreach ($results as $row) {  
            $a = array();
            array_push($a, trim($row["status"], " \r."));
            array_push($a, intval($row["count"]));
            array_push($data, $a);
        };

        echo json_encode($data);
        exit;
    }
}