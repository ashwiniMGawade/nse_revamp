
 
<?php include VIEW_PATH."filters.php" ?>
<div class="table-responsive"> 
<?php if(count($checks) > 0) { ?>             
    <table class="table table-hover table-striped table-bordered" id="tblData">
        <thead>
            <tr>
                <th>Server Name<a href="<?php echo sortorder($url, 'servername'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('server');?>"></i></a></th>
                <th>Server IP</th>
                <th>Start DateTime<a href="<?php echo sortorder($url, 'starttime'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('starttime');?>"></i></a></th>
                <th>End DateTime<a href="<?php echo sortorder($url, 'endtime'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('endtime');?>"></i></a></th>
                <th>Source Path</th>
                <th>Mount Path</th>
                <th>Destination Path</th>
                <th>Status&nbsp;&nbsp;<a href="<?php echo sortorder($url, 'status'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('status');?>"></i></a></th>
                <th style="width:5%" >Batch</th>
                <th>Log Dump</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($checks as $row) { ?>
            <tr>
                <td><?php echo $row["servername"]; ?></td>
                <td><?php echo $row["serverip"]; ?></td>
                <td><?php echo $row["starttime"]; ?></td>
                <td ><?php echo $row["endtime"]; ?></td>
                <td class="input-cell"><div><?php echo $row["sourcepath"]; ?></div></td>
                <td class="input-cell"><div><?php echo $row["mountpath"]; ?></div></td>
                <td class="input-cell"><div><?php echo $row["destinationpath"]; ?></div></td>
                <td class="<?php echo ($row['status'] == "Failed" ? "text-danger" : 'text-'.strtolower($row["status"])); ?>"
                ><?php echo $row["status"]; ?></td>
                <td style="width:5%" ><?php echo $row["batchnumber"]; ?></td>
                <td class="input-cell"><?php echo $row["logdump"]; ?></td>
            </tr>
             <?php } ?>
        </tbody>
    </table>
  
    <?php include VIEW_PATH."pagination.php" ?>
    <?php }  else {
            echo "<div class='text-center alert text-warning'><h2> No Records found</h2></div>";   
        }?>
</div>
