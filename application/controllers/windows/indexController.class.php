<?php

// application/controllers/home/IndexController.class.php

require "application/controllers/BaseController.class.php";
require "framework/helpers/paginate.php";
require "framework/helpers/functions.php";

class IndexController extends BaseController{

    public function indexAction() {
        $windowsCopyModel = new WindowsCopyModel("windowscopycheck.windows_copy");
        $copies = $windowsCopyModel->getWindowsCopies();

        $windowsCheckModel = new WindowsCheckModel("windowscopycheckone.windows_check");
        $checks = $windowsCheckModel->getWindowsChecks();

        $windowsServerModel = new WindowsServerModel('nselogserverwindow.windowserverinput');
        $servers = $windowsServerModel->pageRows(0, 10);
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
        $lnavElement = array("element" => "Windows Server", "link"=> "index.php?p=windows");
        $pageContent = CURR_VIEW_PATH . "windowsServer.php";

        include VIEW_PATH."template.php";
    }

    
    public function searchAction(){
        $where = '';
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = urldecode($_GET['search']);
            $where = 'nselogserverwindow.windowserverinput.servername like "%'.$search.'%"';
         }
        $windowsServerModel = new WindowsServerModel('nselogserverwindow.windowserverinput');
        $servers = $windowsServerModel->pageRows(0, 1000, $where);
        echo json_encode($servers);

    }

    public function serverAction() {
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $serverName = urldecode($_GET['name']);
         } else {
            // default page num
           return $this->windowsAction();
        }
        $windowsCopyModel = new WindowsCopyModel("windowscopycheck.windows_copy");
        $copies = $windowsCopyModel->getWindowsCopies($serverName);

        $windowsCheckModel = new WindowsCheckModel("windowscopycheckone.windows_check");
        $checks = $windowsCheckModel->getWindowsChecks($serverName);

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
            'link' => "index.php?p=windows"
        ];

        $breadcrumbs[] =  (object) [
            'title' => $serverName,
            "isActive" => true
        ];
        $lnavElement = array("element" => "Windows Server", "link"=> "index.php?p=windows");
        $pageContent = CURR_VIEW_PATH . "windowsServer.php";

        include VIEW_PATH."template.php";
    }

    public function copiesAction() {       
        $where = $this->getConditionsData();
        $validStatusToAssign = ["successful", "failed"];
        $windowsCopyModel = new WindowsCopyModel("windowscopycheck.windows_copy");
        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $paginateOptions = paginate( $windowsCopyModel, $rowsperpage, $where);
        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        $sortingInfo = $this->getSortinginfo();

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
            "link" => "index.php?p=windows"
        ];
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $serverName = urldecode($_GET['name']);
            $breadcrumbs[] =  (object) [
                'title' => $serverName,
                "isActive" => false,
                "link" => "index.php?p=windows&name=".$serverName
            ];
        }
        $breadcrumbs[] =  (object) [
            'title' => 'Copy',
            "isActive" => true
        ];
        $lnavElement = array("element" => "Windows Server", "link"=> "index.php?p=windows");

        $pageContent = CURR_VIEW_PATH . "windowsCopies.php";

        include VIEW_PATH."template.php";
    }


    public function checksAction() {
        $where = $this->getConditionsData();
        $validStatusToAssign = ["success", "failed"];
        $windowsCheckModel = new WindowsCheckModel("windowscopycheckone.windows_check");
        $rowsperpage = $GLOBALS['config']['rowsPerPage'];
        $paginateOptions = paginate( $windowsCheckModel, $rowsperpage, $where);
        $offset = $paginateOptions["offset"];
        $currentpage = $paginateOptions["currentpage"];
        $totalpages = $paginateOptions["totalpages"];
        $sortingInfo = $this->getSortinginfo();

        $checks = $windowsCheckModel->pageRows($offset, $rowsperpage, $where, $sortingInfo['order_by'], $sortingInfo['sort']);

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
            "link" => "index.php?p=windows"
        ];
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $serverName = urldecode($_GET['name']);
            $breadcrumbs[] =  (object) [
                'title' => $serverName,
                "isActive" => false,
                "link" => "index.php?p=windows&name=".$serverName
            ];
        }
        $breadcrumbs[] =  (object) [
            'title' => 'Check',
            "isActive" => true
        ];
        $lnavElement = array("element" => "Windows Server", "link"=> "index.php?p=windows");

        $pageContent = CURR_VIEW_PATH . "windowsChecks.php";

        include VIEW_PATH."template.php";
    }

    private function getConditionsData() {
        $where = '';
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $serverName = urldecode($_GET['name']);
            $where = 'LOWER(servername) =LOWER("'. $serverName.'") and ';
        }

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $status = urldecode($_GET['status']);
            $where .= 'LOWER(status) like "'.strtolower($status).'%" and ';
        }

        $fieldName = ($this->isChecks() ? 'dateandtime': 'startdate');
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

    public function downloadAction(){
        $where = $this->getConditionsData();
        $model =  new WindowsCopyModel("windowscopycheck.windows_copy");
        $sortingInfo = $this->getSortinginfo(); 
      
        if ($this->isChecks()) {
            $model =  new WindowsCheckModel("windowscopycheckone.windows_check");
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

}