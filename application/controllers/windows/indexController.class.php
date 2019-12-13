<?php

// application/controllers/home/IndexController.class.php

require "application/controllers/BaseController.class.php";
require "framework/helpers/paginate.php";
require "framework/helpers/functions.php";

class IndexController extends BaseController{

    public function indexAction() {       
        $serverModel = new ServerModel('nselogmanagement.serverList');
        $where = 'nselogmanagement.serverlist.flag = "Windows"';
        $servers = $serverModel->pageRows(0, 2000, $where);
        $showServers = true;
        $serverType = "windows";

        $isMain = true;
        $breadcrumb = array();
        $breadcrumbs[] =  (object) [
            'title' => 'Home',
            'link' =>  "index.php",
            "isActive" => false
          ];
        $breadcrumbs[] =  (object) [
            'title' => 'Windows',
            "isActive" => true
        ];
        $lnavElement = array("element" => "Windows Servers", "link"=> "index.php?p=windows&a=serverList");
        $pageContent = CURR_VIEW_PATH . "windowsServer.php";

        include VIEW_PATH."template.php";
    }

    
    public function searchAction(){
        $where = 'nselogmanagement.serverlist.flag = "Windows"';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = urldecode($_GET['search']);
            $where .= 'and nselogmanagement.serverlist.servername like "%'.$search.'%"';
         }
        $windowsServerModel = new ServerModel('nselogmanagement.serverlist');
        $servers = $windowsServerModel->pageRows(0, 2000, $where);
        echo json_encode($servers);

    }

    public function serverAction() {
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $serverName = $_GET['name'];
         } else {
            // default page num
           return $this->windowsAction();
        }
        $where = 'nselogmanagement.serverlist.flag = "Windows"';
        $windowsServerModel = new ServerModel('nselogmanagement.serverlist');
        $servers = $windowsServerModel->pageRows(0, 2000, $where);

        $showServers = true;
        $serverType = "windows";

        $isMain = true;
        $breadcrumb = array();
        $breadcrumbs[] =  (object) [
            'title' => 'Home',
            'link' =>  "index.php",
            "isActive" => false
          ];
        $breadcrumbs[] =  (object) [
            'title' => 'Windows',
            "isActive" => false,
            'link' => "index.php?p=windows&serverStatus=today"
        ];

        $breadcrumbs[] =  (object) [
            'title' => implode(',', $serverName),
            "isActive" => true
        ];
        $lnavElement = array("element" => "Windows Servers", "link"=> "index.php?p=windows&a=serverList");
        $pageContent = CURR_VIEW_PATH . "windowsServer.php";

        include VIEW_PATH."template.php";
    }

    public function copiesAction() {       
        $where = $this->getConditionsData();
        $validStatusToAssign = ["success", "failed"];
        $windowsCopyModel = new WindowsCopyModel("nselogmanagement.windowslog");
        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $paginateOptions = paginate( $windowsCopyModel, $rowsperpage, $where);
        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        $sortingInfo = $this->getSortinginfo();

        $where1 = 'nselogmanagement.serverlist.flag = "Windows"';
        $windowsServerModel = new ServerModel('nselogmanagement.serverlist');
        $servers = $windowsServerModel->pageRows(0, 2000, $where1);

        $copies = $windowsCopyModel->pageRows($offset, $rowsperpage, $where, $sortingInfo['order_by'], $sortingInfo['sort']);
        $url = $this->getUrl();

        $showServers = true;
        $serverType = "windows";

        $isMain = true;
        $breadcrumb = array();
        $breadcrumbs[] =  (object) [
            'title' => 'Home',
            'link' =>  "index.php",
            "isActive" => false
          ];
        $breadcrumbs[] =  (object) [
            'title' => 'Windows',
            "isActive" => false, 
            "link" => "index.php?p=windows&serverStatus=today"
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
        $lnavElement = array("element" => "Windows Servers", "link"=> "index.php?p=windows&a=serverList");

        $pageContent = CURR_VIEW_PATH . "windowsCopies.php";

        include VIEW_PATH."template.php";
    }

    private function getConditionsData() {
        $where = '';
        if (isset($_GET['name']) && !empty($_GET['name'])) {            
            $where = '(';
            foreach($_GET['name'] as $servername) {
                $where .= 'LOWER(servername) =LOWER("'. $servername.'") or ';
            }
            $where .= ' 0 ) and ';
        }


        if (isset($_GET['status']) && $_GET['status'] != '') {
            $status = urldecode($_GET['status']);
            $where .= 'LOWER(status) like "'.strtolower($status).'%" and ';
        }

        $fieldName = 'starttime';
        if (isset($_GET['startDate']) && $_GET['startDate'] != '' && isset($_GET['endDate']) && $_GET['endDate'] != '') {
            $startdate = urldecode($_GET['startDate']);
            $enddate = urldecode($_GET['endDate']);  
            $date = new DateTime($startdate);
            $startdate = $date->format("Y-m-d H:i:s");
            $date1 = new DateTime($enddate);
            $enddate = $date1->format("Y-m-d H:i:s");
            // $startdate = date('Y-m-d h:m:s', strtotime($startdate));
            // $enddate = date('Y-m-d h:m:s', strtotime($enddate));
        
            $where .= '('.$fieldName.' between "'.$startdate. '" and "'.$enddate.'") and ';
        } else {
            if (isset($_GET['startDate']) && $_GET['startDate'] != '') {
                $startdate = urldecode($_GET['startDate']);
                $date = new DateTime($startdate);
                $startdate = $date->format("Y-m-d H:i:s");
                // $startdate = date('Y-m-d h:m:s', strtotime($startdate));
                $where .= '('.$fieldName.') >="'.$startdate.'" and ';
            }
    
            if (isset($_GET['endDate']) && $_GET['endDate'] != '') {
                $enddate = urldecode($_GET['endDate']);
                $date1 = new DateTime($enddate);
                $enddate = $date1->format("Y-m-d H:i:s");
                // $enddate = date('Y-m-d h:m:s', strtotime($enddate));
                $where .= '('.$fieldName.') <="'.$enddate.'" and ';
            }    
        } 

        $where .= " 1 ";
        return $where;
    }

    public function downloadAction(){
        $where = $this->getConditionsData();
        $model =  new WindowsCopyModel("nselogmanagement.windowslog");
        $sortingInfo = $this->getSortinginfo(); 
       
        $data = $model->pageRows(0, 1000, $where, $sortingInfo['order_by'], $sortingInfo['sort']);

        download_send_headers("data_export_windows_" . date("Y-m-d") . ".csv");
        echo array2csv($data);
        die();
    
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
        $results = '';   
        $model =  new WindowsCopyModel("nselogmanagement.windowslog");
        $results = $model->getWindowsCopies( $serverName, $day);       

        $data = array();
        $data[0]= array("Status", "Count");

       
        $validStatusToAssign = ["Success", "Failed"];
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
              
        $model =  new WindowsCopyModel("nselogmanagement.windowslog");
        $results = $model->getWindowsServerStatus($serverStatus);
     
        $where = 'nselogmanagement.serverlist.flag = "Windows" and nselogmanagement.serverlist.logcollection = "Enabled" ';
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
        $windowsCopyModel = new WindowsCopyModel("nselogmanagement.windowslog");
        $copies = $windowsCopyModel->getWindowsServerStatus($serverStatus);

        $windowsServerModel = new ServerModel('nselogmanagement.serverlist');
        $where1 = 'nselogmanagement.serverlist.flag = "Windows" and nselogmanagement.serverlist.logcollection = "Enabled" ';
        $servers = $windowsServerModel->pageRows(0, 2000, $where1);

        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
       
        $serversPresent = array_column($copies, 'servername');
        if (count($serversPresent) > 0) {
            $where1 .= ' and nselogmanagement.serverlist.servername not in ("'. implode('","', $serversPresent). '")';
        }

        $paginateOptions = paginate( $windowsServerModel, $rowsperpage, $where1);
        
        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        
        

        $results = $windowsServerModel->pageRows($offset, $rowsperpage, $where1);

        $url = $this->getUrl();
      
        $showServers = true;
        $serverType = "windows";      

        $isMain = true;
        $breadcrumb = array();
        $breadcrumbs[] =  (object) [
            'title' => 'Home',
            'link' =>  "index.php",
            "isActive" => false
          ];
        $breadcrumbs[] =  (object) [
            'title' => 'Windows',
            "isActive" => false, 
            "link" => "index.php?p=windows&serverStatus=today"
        ];
        if (isset($_GET['serverStatus']) && !empty($_GET['serverStatus'])) {
            $link = "index.php?p=windows&a=serverStatus&serverStatus=".$_GET['serverStatus'];
            $breadcrumbs[] =  (object) [
                'title' => "Logs not run on ". $_GET['serverStatus'],
                "isActive" => true,
                "link" => $link
            ];
        }
       
        $lnavElement = array("element" => "Windows Servers", "link"=> "index.php?p=windows&a=serverList");

        $pageContent = VIEW_PATH . "notRunServerList.php";

        include VIEW_PATH."template.php";
    }

    public function serverListAction() {
        $serverModel = new ServerModel('nselogmanagement.serverList');
        $where = 'nselogmanagement.serverlist.flag = "Windows"';


        $servers = $serverModel->pageRows(0, 2000, $where);
        $showServers = true;

        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = urldecode($_GET['search']);
            $where .= 'and (nselogmanagement.serverlist.servername like "%'.$search.'%" or  nselogmanagement.serverlist.serverip like "%'.$search.'%")';
        }

        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $paginateOptions = paginate( $serverModel, $rowsperpage, $where);

        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        
        $results = $serverModel->pageRows($offset, $rowsperpage, $where);

        $url = $this->getUrl();
      
        $serverType = "windows";

        $isMain = true;
        $breadcrumb = array();
        $breadcrumbs[] =  (object) [
            'title' => 'Home',
            'link' =>  "index.php",
            "isActive" => false
          ];
          $breadcrumbs[] =  (object) [
            'title' => 'Windows',
            "isActive" => false,
            'link' => "index.php?p=windows&serverStatus=today"
        ];

        $breadcrumbs[] =  (object) [
            'title' => 'Servers',
            "isActive" => true
        ];
        $lnavElement = array("element" => "Windows Servers", "link"=> "index.php?p=windows&a=serverList");

        $pageContent = VIEW_PATH . "serverList.php";

        include VIEW_PATH."template.php";
    }
}