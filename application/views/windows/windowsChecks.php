<?php if(count($checks) > 0) { ?>
<div class="filters row">
  <div class="col-md-2">
    <button type="button" class="btn btn-warning" onclick="exportTableToExcel()" serverType="<?php echo PLATFORM; ?>" id="export" type="copies">Export to file</button>
  </div>
 
  <?php include VIEW_PATH."filters.php" ?>
</div>

<div class="table-responsive">          
    <table class="table table-hover table-striped table-bordered" id="tblData">
        <thead>
            <tr>
                <th>Server Name</th>
                <th>Local Drive</th>
                <th>Network Path</th>
                <th>Drive Exist</th>
                <th>Write Permission</th>
                <th>Copy Permission</th>
                <th>Mounting Status</th>
                <th>Date and Time</th>
                <th>Status</th>
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
                <td><?php echo $row["status"]; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php include VIEW_PATH."pagination.php" ?>
</div>
<?php }  else {
    echo "<div class='row text-center'><h2> No Records found</h2></div>";   
}?>