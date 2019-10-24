<?php include VIEW_PATH."filters.php" ?>

<div class="table-responsive">      
<?php if(count($checks) > 0) { ?>    
    <table class="table table-hover table-striped table-bordered" id="tblData">
        <thead>
            <tr>
                <th>Server Name<a href="<?php echo sortorder($url, 'servername'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('servername');?>"></i></a></th>
                <th>Local Drive</th>
                <th>Network Path</th>
                <th>Drive Exist</th>
                <th>Write Permission</th>
                <th>Copy Permission</th>
                <th>Mounting Status</th>
                <th>Date and Time<a href="<?php echo sortorder($url, 'dateandtime'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('dateandtime');?>"></i></a></th>
                <th>Status &nbsp;&nbsp;&nbsp;<a href="<?php echo sortorder($url, 'status'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('status');?>"></i></a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($checks as $row) { ?>
            <tr>
                <td><?php echo $row["servername"]; ?></td>
                <td><?php echo $row["localdrive"]; ?></td>
                <td><?php echo $row["networkpath"]; ?></td>
                <td><?php echo $row["driveexist"]; ?></td>
                <td><?php echo $row["filewritepermission"]; ?></td>
                <td><?php echo $row["copypermission"]; ?></td>
                <td><?php echo $row["mountingstatus"]; ?></td>
                <td><?php echo $row["dateandtime"]; ?></td>
                <td class="<?php echo ($row['status'] == "failed" ? "text-danger" : 'text-'.strtolower($row["status"])); ?>"><?php echo $row["status"]; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php include VIEW_PATH."pagination.php" ?>
</div>
<?php }  else {
     echo "<div class='text-center alert text-warning'><h2> No Records found</h2></div>";   
}  ?>