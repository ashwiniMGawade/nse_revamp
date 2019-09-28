<?php if(count($copies) > 0) { ?>
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
        <th>Source Path</th>
        <th>Destination Path</th>
        <th>Destination Mount Point</th>
        <th>Start DateTime</th>
        <th>End DateTime</th>
        <th>Status</th>
        <th>Log Dump</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($copies as $row) { 
            if($row["status"] == "Failed"){
        ?>
      <tr class="danger">
       <td><?php echo $row["servername"]; ?></td>
        <td><?php echo $row["localdrive"]; ?></td>
        <td><?php echo $row["networkpath"]; ?></td>
        <td><?php echo $row["sourcepath"]; ?></td>
        <td><?php echo $row["destinationpath"]; ?></td>
        <td><?php echo $row["destinaitonpathformounting"]; ?></td>
        <td><?php echo $row["startdate"]; ?></td>
        <td><?php echo $row["enddate"]; ?></td>
        <td><?php echo $row["status"]; ?></td>
        <td><?php echo $row["logdump"]; ?></td>
            </tr>
            <?php 
        } if($row["status"] == "Successful"){ ?>
            <tr class="Success">
            <td><?php echo $row["servername"]; ?></td>
        <td><?php echo $row["localdrive"]; ?></td>
        <td><?php echo $row["networkpath"]; ?></td>
        <td><?php echo $row["sourcepath"]; ?></td>
        <td><?php echo $row["destinationpath"]; ?></td>
        <td><?php echo $row["destinaitonpathformounting"]; ?></td>
        <td><?php echo $row["startdate"]; ?></td>
        <td><?php echo $row["enddate"]; ?></td>
        <td><?php echo $row["status"]; ?></td>
        <td><?php echo $row["logdump"]; ?></td>
      </tr>
            <?php 
        }} ?>
    </tbody>
  </table>

  <?php include VIEW_PATH."pagination.php" ?>
</div>
<?php }  else {
    echo "<div class='row text-center'><h2> No Records found</h2></div>";   
}?>