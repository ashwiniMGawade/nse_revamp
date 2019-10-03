<?php
class BaseController{
    public function getUrl() {
        $url = $_SERVER['PHP_SELF'] . '?p='.PLATFORM.'&a='.ACTION;

        if (isset($_GET['name']) && $_GET['name'] != '') {
            $serverName = urldecode($_GET['name']);
            $url .= "&name=". $serverName;
        }

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $status = urldecode($_GET['status']);
            $url .= "&status=". $status;
        }

        if (isset($_GET['startDate']) && $_GET['startDate'] != '') {
            $startdate = urldecode($_GET['startDate']);
            $url .= "&startDate=". $startdate;
        }

        if (isset($_GET['endDate']) && $_GET['endDate'] != '') {
            $enddate = urldecode($_GET['endDate']);
            $url .= "&endDate=". $enddate;
        }     
       return $url;
    }

    public function getSortinginfo() {
        $response = array("order_by" => "id", "sort" => "asc");
        if (isset($_GET['order_by']) && $_GET['order_by'] != '') {
            $response["order_by"] = $_GET['order_by'];
        } 

        if (isset($_GET['sort']) && $_GET['sort'] != '') {
            $response["sort"] = $_GET['sort'];
        }
        return $response;
    }
}