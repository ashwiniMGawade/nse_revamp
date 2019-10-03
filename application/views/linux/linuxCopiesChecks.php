
<div class="filters row">
  <div class="col-md-2">
    <button type="button" class="btn btn-warning" onclick="exportTableToExcel()" serverType="<?php echo PLATFORM; ?>" id="export" type="copies">Export to file</button>
  </div>
 
  <?php include VIEW_PATH."filters.php" ?>
</div>
<div class="table-responsive"> 
<?php if(count($checks) > 0) { ?>             
    <table class="table table-hover table-striped table-bordered" id="tblData">
        <thead>
            <tr>
                <th>Server Name<a href="<?php echo sortorder($url, 'server'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('server');?>"></i></a></th>
                <th style="width:5%" >Destination</th>
                <th>Start DateTime<a href="<?php echo sortorder($url, 'startdate'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('startdate');?>"></i></a></th>
                <th>End DateTime<a href="<?php echo sortorder($url, 'enddate'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('enddate');?>"></i></a></th>
                <th>Source Path</th>
                <th>Destination Path</th>
                <th>Status<a href="<?php echo sortorder($url, 'status'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('status');?>"></i></a></th>
                <th style="width:5%" >Batch</th>
                <th>JOB ID</th>
                <th>Log Dump</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($checks as $row) { ?>
            <tr>
                <td><?php echo $row["server"]; ?></td>
                <td style="width:5%" ><?php echo $row["destination"]; ?></td>
                <td><?php echo $row["startdate"]; ?></td>
                <td ><?php echo $row["enddate"]; ?></td>
                <td class="input-cell"><div><?php echo $row["sourcepath"]; ?></div></td>
                <td class="input-cell"><div><?php echo $row["destinationpath"]; ?></div></td>
                <td ><?php echo $row["status"]; ?></td>
                <td style="width:5%" ><?php echo $row["batch"]; ?></td>
                <td ><?php echo $row["mwfaid"]; ?></td>
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
