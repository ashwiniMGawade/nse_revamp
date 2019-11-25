<?php

// application/controllers/home/IndexController.class.php

require "application/controllers/BaseController.class.php";
require "framework/helpers/paginate.php";
require "framework/helpers/functions.php";

class IndexController extends BaseController{

    public function indexAction() {
        $serverModel = new ServerModel('nselogmanagement.serverList');
        $where = 'nselogmanagement.serverlist.flag = "Unix"';
        $servers = $serverModel->pageRows(0, 2000, $where);
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
        $lnavElement = array("element" => "Linux Servers", "link"=> "index.php?p=linux&a=serverList");

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
        $servers = $serverModel->pageRows(0, 2000, $where);
        echo json_encode($servers);

    } 
    
    private function getConditionsData() {
        $where = '';
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $fieldname = "servername";          
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

        $datefieldName = 'starttime';
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
            "link" => "index.php?p=linux&serverStatus=today"
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

       
        $lnavElement = array("element" => "Linux Servers", "link"=> "index.php?p=linux&a=serverList");

        $pageContent = CURR_VIEW_PATH . "linuxCopies.php";

        include VIEW_PATH."template.php";
    }
 
    public function serverAction() {
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $serverName = $_GET['name'];
         } else {
            // default page num
           return $this->linuxAction();
        }
        
        $showServers = true;
        $serverModel = new ServerModel('nselogmanagement.serverList');
        $where = 'nselogmanagement.serverlist.flag = "Unix"';
        $servers = $serverModel->pageRows(0, 2000, $where);

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
            'link' => "index.php?p=linux&serverStatus=today"
        ];

        $breadcrumbs[] =  (object) [
            'title' => implode(',', $serverName),
            "isActive" => true
        ];
        $lnavElement = array("element" => "Linux Servers", "link"=> "index.php?p=linux&a=serverList");
        $pageContent = CURR_VIEW_PATH . "linuxServer.php";

        include VIEW_PATH."template.php";
    }

    public function downloadAction(){
        $where = $this->getConditionsData();
        $model =  new LinuxCopyModel("nselogmanagement.unixlog");
        $sortingInfo = $this->getSortinginfo(); 
        $data = $model->pageRows(0, 100000, $where, $sortingInfo['order_by'], $sortingInfo['sort']);

        download_send_headers("data_export_windows_" . date("Y-m-d") . ".csv");
        echo array2csv($data);
        die();
    
    }
    public function getDataAction() {    
        $serverName = array();
        if (isset($_POST['name']) && !empty($_POST['name'])) {      
            $serverName = $_POST['name'];
        }
        $day = '';

        if (isset($_POST['day']) && $_POST['day'] != '') {      
            $day = urldecode($_POST['day']);
        }
        $validStatusToAssign = ["Success",  "Warning", "Started", "In-Progress", "Failed"]; 
        $model =  new LinuxCopyModel("nselogmanagement.unixlog");
        $results = $model->getLinuxCopies( $serverName, $day);
        $data = array();
        $data[0]= array("Status", "Count");

       
        $result_statuses = array_column($results, "status");
        $remainingStatuses = array_diff($validStatusToAssign, $result_statuses);

        if (count($remainingStatuses) > 0) {
            foreach ($remainingStatuses as $status) {  
                array_push($results, array("status"=> $status, "count" => 0));
            }
        }
        $statuses_values = array_column($results, "status");
        array_multisort($statuses_values, SORT_ASC ,$results);
        foreach ($results as $row) {  
            $a = array();
            array_push($a, trim($row["status"], " \r."));
            array_push($a, intval($row["count"]));
            array_push($data, $a);
        };

        echo json_encode($data);
        exit;
    }

    public function getServerDataAction() {    
        $serverStatus = 'today';
        if (isset($_POST['serverStatus']) && !empty($_POST['serverStatus'])) {      
            $serverStatus = urldecode($_POST['serverStatus']);
        }

        $validStatusToAssign = ["Run", "Not Run"]; 
              
        $model =  new LinuxCopyModel("nselogmanagement.unixlog");
        $results = $model->getLinuxServerStatus($serverStatus);
     
        $where = 'nselogmanagement.serverlist.flag = "Unix" and nselogmanagement.serverlist.logcollection = "Enabled" ';
        $serverModel = new ServerModel('nselogmanagement.serverList');
        $total = $serverModel->total($where);
        $data = array();
        $data[0]= array("Status", "Count");
        $data[1] = array("Run",  count( $results));
        $data[2] = array("Not Run",  $total - count( $results));
      
        echo json_encode($data);
        exit;
    }

    public function serverStatusAction() {  
        $serverStatus = 'today';
        if (isset($_GET['serverStatus']) && !empty($_GET['serverStatus'])) {      
            $serverStatus = urldecode($_GET['serverStatus']);
        }
        $linuxCopyModel = new LinuxCopyModel("nselogmanagement.unixlog");
        $copies = $linuxCopyModel->getLinuxServerStatus($serverStatus);

        $linuxServerModel = new ServerModel('nselogmanagement.serverlist');
        $where1 = 'nselogmanagement.serverlist.flag = "Unix" ';
        $servers = $linuxServerModel->pageRows(0, 2000, $where1);

        $where1 .= ' and nselogmanagement.serverlist.logcollection = "Enabled"';   
        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $serversPresent = array_column($copies, 'servername');
        if (count($serversPresent) > 0) {
            $where1 .= ' and nselogmanagement.serverlist.servername not in ("'. implode('","', $serversPresent). '")';
        }

        $paginateOptions = paginate( $linuxServerModel, $rowsperpage, $where1);

        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        
       
        $results = $linuxServerModel->pageRows($offset, $rowsperpage, $where1);

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
            "link" => "index.php?p=linux&serverStatus=today"
        ];
        if (isset($_GET['serverStatus']) && !empty($_GET['serverStatus'])) {
            $link = "index.php?p=linux&a=serverStatus&serverStatus=".$_GET['serverStatus'];
            $breadcrumbs[] =  (object) [
                'title' => "Logs not run on ". $_GET['serverStatus'],
                "isActive" => true,
                "link" => $link
            ];
        }
       
        $lnavElement = array("element" => "Linux Servers", "link"=> "index.php?p=linux&a=serverList");

        $pageContent = VIEW_PATH . "notRunServerList.php";

        include VIEW_PATH."template.php";
    }

    public function serverListAction() {
        $serverModel = new ServerModel('nselogmanagement.serverList');
        $where = 'nselogmanagement.serverlist.flag = "Unix"';
        $servers = $serverModel->pageRows(0, 2000, $where);
        $showServers = true;

        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $paginateOptions = paginate( $serverModel, $rowsperpage, $where);

        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        
        $results = $serverModel->pageRows($offset, $rowsperpage, $where);

        $url = $this->getUrl();
      
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
            'link' => "index.php?p=linux&serverStatus=today"
        ];

        $breadcrumbs[] =  (object) [
            'title' => 'Servers',
            "isActive" => true
        ];
        $lnavElement = array("element" => "Linux Servers", "link"=> "index.php?p=linux&a=serverList");

        $pageContent = VIEW_PATH . "serverList.php";

        include VIEW_PATH."template.php";
    }
}