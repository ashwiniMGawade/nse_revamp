<?php include VIEW_PATH."filters.php" ?>

<div class="table-responsive">      
<?php if(count($checks) > 0) { ?>    
    <table class="table table-hover table-striped table-bordered" id="tblData">
        <thead>
            <tr>
                <th>Server Name<a href="<?php echo sortorder($url, 'servername'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('servername');?>"></i></a></th>
                <th>Server IP</th>
                <th>Mount Path</th>
                <th>Network Path</th>
                <th>Mount Exist</th>
                <th>Mount Type</th>
                <th>Date and Time<a href="<?php echo sortorder($url, 'time'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('time');?>"></i></a></th>
                <th>Status &nbsp;&nbsp;&nbsp;<a href="<?php echo sortorder($url, 'status'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('status');?>"></i></a></th>
                <th>Log Dump</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($checks as $row) { ?>
            <tr>
                <td><?php echo $row["servername"]; ?></td>
                <td><?php echo $row["serverip"]; ?></td>
                <td><?php echo $row["mountpath"]; ?></td>
                <td><?php echo $row["networkpath"]; ?></td>
                <td><?php echo $row["mountexist"]; ?></td>
                <td><?php echo $row["mounttype"]; ?></td>
                <td><?php echo $row["time"]; ?></td>
                <td class="<?php echo ($row['status'] == "Failed" ? "text-danger" : 'text-'.strtolower($row["status"])); ?>"><?php echo $row["status"]; ?></td>
                <td><?php echo $row["logdump"]; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php include VIEW_PATH."pagination.php" ?>
</div>
<?php }  else {
     echo "<div class='text-center alert text-warning'><h2> No Records found</h2></div>";   
}  ?>