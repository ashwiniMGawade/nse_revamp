<?php include VIEW_PATH."filters.php" ?>
<div class="table-responsive">     
<?php if(count($copies) > 0) { ?>     
  <table class="table table-hover table-striped table-bordered" id="tblData">
    <thead>
      <tr>
        <th>Server Name<a href="<?php echo sortorder($url, 'servername'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('servername');?>"></i></a></th>
        <th>Server IP</th>
        <th>Local Drive</th>
        <th>Network Path</th>
        <th>Destination Path</th>
        <th>Start DateTime <a href="<?php echo sortorder($url, 'starttime'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('starttime');?>"></i></a></th>
        <th>End DateTime <a href="<?php echo sortorder($url, 'endtime'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('endtime');?>"></i></a></th>
        <th>Status&nbsp;&nbsp;&nbsp;<a href="<?php echo sortorder($url, 'status'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('status');?>"></i></a></th>
        <th>Log Dump</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($copies as $row) { 
            if($row["status"] == "Failed"){
        ?>
      <tr >
        <td><?php echo $row["servername"]; ?></td>
        <td><?php echo $row["serverip"]; ?></td>
        <td><?php echo $row["localdrive"]; ?></td>
        <td><?php echo $row["networkpath"]; ?></td>
        <td><?php echo $row["destinationpath"]; ?></td>
        <td><?php echo $row["starttime"]; ?></td>
        <td><?php echo $row["endtime"]; ?></td>
        <td class="text-danger"><?php echo $row["status"]; ?></td>
        <td><?php echo $row["logdump"]; ?></td>
            </tr>
            <?php 
        } if($row["status"] == "Success"){ ?>
            <tr class="Success">
        <td><?php echo $row["servername"]; ?></td>
        <td><?php echo $row["serverip"]; ?></td>
        <td><?php echo $row["localdrive"]; ?></td>
        <td><?php echo $row["networkpath"]; ?></td>
        <td><?php echo $row["destinationpath"]; ?></td>
        <td><?php echo $row["starttime"]; ?></td>
        <td><?php echo $row["endtime"]; ?></td>
        <td class="text-success"><?php echo $row["status"]; ?></td>
        <td><?php echo $row["logdump"]; ?></td>
      </tr>
            <?php 
        }} ?>
    </tbody>
  </table>

  <?php include VIEW_PATH."pagination.php" ?>
</div>
<?php }  else {
     echo "<div class='text-center alert text-warning'><h2> No Records found</h2></div>";   
}  ?>