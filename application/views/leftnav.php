<ul class="nav nav-pills nav-stacked">
    <li class="active" style="  text-align:center;"><a href="<?php echo  $lnavElement['link']; ?>"><?php echo $lnavElement['element']; ?></a></li>
    <!--<li><a href="#">Window Server</a></li>
    <li><a href="#">Linux Server</a></li>-->
</ul>

<?php if( isset($showServers) && $showServers) { ?>
    <script src="public/js/lib/searchServer.js"></script>

<?php
    echo '<section class="serversSection">'.
            '<input class="form-control" type="text" placeholder="Search" aria-label="Search" id="search"'.
            ' serverType="'.$serverType.'"  onkeyup="search(this.value)"><div class="loader" style="display:none;"></div>'.
            '<ul id="serverList" class="list-group list-group-flush">';
    if(isset($servers)) {
        if(count($servers)== 0) { 
            echo "<li>No Records found</li>";
        }
        foreach($servers as $row) {
            if(isset($row['servername']) && $row['servername'] != '')  {
                echo '<a class="list-group-item list-group-item-action" href="index.php?p='.PLATFORM.'&a=server&name[]='.urlencode($row['servername']).'"><li>'. $row['servername'].'</li></a>';
            } 
        }
    }  
    echo '</ul></section>';
} ?>