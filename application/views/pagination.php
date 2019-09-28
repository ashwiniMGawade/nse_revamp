<?php
/******  build the pagination links ******/
// range of num links to show
$range = 3;

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
   $url .= "&endtDate=". $enddate;
}
echo "<ul class='pagination'>";

// if not on page 1, don't show back links
if ($currentpage > 1) {
   // show << link to go back to page 1
   echo "<li> <a href='{$url}&page=1'><<</a></li> ";
   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go back to 1 page
   echo "<li> <a href='{$url}&page=$prevpage'><</a></li> ";
} // end if 

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
   // if it's a valid page number...
   if (($x > 0) && ($x <= $totalpages)) {
      // if we're on current page...
      if ($x == $currentpage) {
         // 'highlight' it but don't make a link
         echo "<li class='active'><a href='#'><b>$x</b></a></li>";
      // if not current page...
      } else {
         // make it a link
         echo "<li> <a href='{$url}&page=$x'>$x</a></li> ";
      } // end else
   } // end if 
} // end for

// if not on last page, show forward and last page links        
if ($currentpage != $totalpages) {
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page 
   echo "<li> <a href='{$url}&page=$nextpage'>></a></li> ";
   // echo forward link for lastpage
   echo "<li> <a href='{$url}&page=$totalpages'>>></a></li> ";
} // end if
/****** end build pagination links ******/

echo "</ul>"

?>