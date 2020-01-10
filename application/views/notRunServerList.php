
 
<div class="filters row">
  <form name="search_frm" id="search_frm" method="get" action="index.php" 
     enctype="multipart/form-data" class="form-inline">  
    <div class=" form-group">
      <span class="btn btn-primary" onclick="exportStatusTableToExcel()" serverType="<?php echo PLATFORM; ?>" id="export"  data-toggle="tooltip"  title="Export to File">
        <span class="glyphicon glyphicon-export" style="color:white;"></span>
      </span>
    </div>
    <div class="form-group font12">
      <select id="multi-select-demo" multiple="multiple" name="name[]" title="text" class="font12">
        <?php 
          foreach($allServersInDropDown as $row) { 
            if ($row['servername'] != '') {
            echo "<option value='".$row['servername']."'>".$row['servername']."</option>";
            }
          }
            ?>
      </select>
    </div>
    <div class="form-group ">
        <span class="btn btn-primary" onclick="search_frm.submit();" data-toggle="tooltip" title="Search">
            <span class="glyphicon glyphicon-search" style="color:white;"></span>
        </span>
        <span class="btn btn-danger" onclick="javascript:window.location='index.php?p=<?php echo PLATFORM; ?>&a=<?php echo ACTION;?>&serverStatus=<?php echo $_GET['serverStatus'];?>';" data-toggle="tooltip" title="Clear Filter">
            <span class="glyphicon glyphicon-erase" style="color:white;"></span>
        </span>
        <input name="p" type="hidden" value="<?php echo PLATFORM; ?>">
        <input name="a" type="hidden" value="<?php echo ACTION; ?>">   
        <input name="serverStatus" type="hidden" value="<?php echo $_GET["serverStatus"]; ?>">            
    </div>
  </form>
</div>
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
                <td><?php echo $_GET["serverStatus"] == "today"?  date('Y-m-d',strtotime("-1 days")) : $_GET["serverStatus"] ?></td>
            </tr>
             <?php } ?>
        </tbody>
    </table>
  
    <?php include VIEW_PATH."pagination.php" ?>
    <?php }  else {
            echo "<div class='text-center alert text-warning'><h2> No Records found</h2></div>";   
        }?>
</div>
