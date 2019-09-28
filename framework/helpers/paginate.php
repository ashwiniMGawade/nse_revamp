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


?>