
 
<?php //include VIEW_PATH."filters.php" ?>
<div class="table-responsive"> 
<?php if(count($results) > 0) { ?>             
    <table class="table table-hover table-striped table-bordered" id="tblData">
        <thead>
            <tr>
                <th>Server Name<a href="<?php echo sortorder($url, 'servername'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('server');?>"></i></a></th>
                <th>Server IP</th>               
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($results as $row) { ?>
            <tr>
                <td><?php echo $row["servername"]; ?></td>
                <td><?php echo $row["serverip"]; ?></td>
                <td><?php echo $_GET["serverStatus"] == "today"? date("y-m-d") : $_GET["serverStatus"] ?></td>
            </tr>
             <?php } ?>
        </tbody>
    </table>
  
    <?php include VIEW_PATH."pagination.php" ?>
    <?php }  else {
            echo "<div class='text-center alert text-warning'><h2> No Records found</h2></div>";   
        }?>
</div>
