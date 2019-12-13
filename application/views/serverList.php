
 
<?php //include VIEW_PATH."filters.php" ?>

<div class="filters">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-5">
            <input autofocus class="form-control" type="text" placeholder="Search by Name or IP. Press enter to search." aria-label="Search" id="searchServer" serverType="$serverType"  onkeyup="searchServer(event, this.value)" value="<?php echo isset($_GET['search'])? $_GET['search'] : ''; ?>">
        </div>
        <div class="col-sm-4">
        <span class="btn btn-danger" onclick="javascript:window.location='index.php?p=<?php echo PLATFORM; ?>&a=<?php echo ACTION;?>';" data-toggle="tooltip" title="Clear Filter">
              <span class="glyphicon glyphicon-erase" style="color:white;"></span>
          </span>
        </div>
    </div>
</div>
<div class="table-responsive"> 
<?php if(count($results) > 0) { ?>             
    <table class="table table-hover table-striped table-bordered" id="tblData">
        <thead>
            <tr>
                <th>Server Name<a href="<?php echo sortorder($url, 'servername'); ?>"><i class="fa fa-fw fa-sort <?php echo getSortClass('server');?>"></i></a></th>
                <th>Server IP</th>               
                <th>Source Path</th>
                <th>Network Path</th>
                <th>Log Path</th>
                <th>Log Collection</th>
                <th>Batch Number</th>
                <th>Schedule</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($results as $row) { ?>
            <tr>
                <td><?php echo $row["servername"]; ?></td>
                <td><?php echo $row["serverip"]; ?></td>
                <td><?php echo $row["sourcepath"]; ?></td>
                <td><?php echo $row["networkpath"]; ?></td>
                <td><?php echo $row["logpath"]; ?></td>
                <td><?php echo $row["logcollection"]; ?></td>
                <td><?php echo $row["batchnumber"]; ?></td>
                <td><?php echo $row["schedule"]; ?></td>
            </tr>
             <?php } ?>
        </tbody>
    </table>
  
    <?php include VIEW_PATH."pagination.php" ?>
    <?php }  else {
            echo "<div class='text-center alert text-warning'><h2> No Records found</h2></div>";   
        }?>
</div>
