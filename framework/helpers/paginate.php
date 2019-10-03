<?php

function paginate($model, $rowsperpag, $where = '') {
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        // cast var as int
        $currentpage = (int) $_GET['page'];
     } else {
        // default page num
        $currentpage = 1;
    }
    $rowsperpage = 10;
    $numrows = $model->total($where);
    $totalpages = ceil($numrows / $rowsperpage);
    $offset = ($currentpage - 1) * $rowsperpage;

    return array(
        'totalpages' =>  $totalpages,
        'currentpage' => $currentpage,
        'offset' => $offset
    );
}

function sortorder($url, $fieldname){
    $sorturl = $url . "&order_by=".$fieldname."&sort=";
    $sorttype = "asc";
    if(isset($_GET['order_by']) && $_GET['order_by'] == $fieldname){
        if(isset($_GET['sort']) && $_GET['sort'] == "asc"){
            $sorttype = "desc";
        } else {
            $sorttype = "asc";
        }
    }
    $sorturl .= $sorttype;
    return $sorturl;
}

function getSortClass($fieldname) {
    $class = "";
    if(isset($_GET['order_by']) && $_GET['order_by'] == $fieldname){
        if(isset($_GET['sort']) && $_GET['sort'] == "asc"){
            $class = "fa-sort-desc active";
        } else {
            $class = "fa-sort-asc active";
        }
    }

    return $class;
}




?>