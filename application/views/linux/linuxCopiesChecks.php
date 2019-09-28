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
                <th style="width:5%" >Destination</th>
                <th>Start DateTime</th>
                <th>End DateTime</th>
                <th>Source Path</th>
                <th>Destination Path</th>
                <th>Status</th>
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
</div>
<?php }  else {
    echo "<div class='row text-center'><h2> No Records found</h2></div>";   
}?>