<?php
/******  build the pagination links ******/
// range of num links to show
$range = 3;

if (isset($_GET['order_by']) && $_GET['order_by'] != '') {
   $url .= "&order_by=".$_GET['order_by'];
} 

if (isset($_GET['sort']) && $_GET['sort'] != '') {
   $url .= "&sort=".$_GET['sort'];
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