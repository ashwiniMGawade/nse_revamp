<form name="search_frm" id="search_frm" method="get" action="index.php" enctype="multipart/form-data">  
      <div class="col-md-3">
        <div class="form-group">
          <select class="form-control" id="exampleFormControlSelect1" name="status">
            <option value="">Filter by Status</option>
            <?php  foreach($validStatusToAssign as $row) { ?>
                <option value="<?php echo $row;?>" <?php echo (isset($_GET['status']) && $_GET['status'] === $row) ? 'selected' : '' ;?>><?php echo ucfirst($row);?></option>
            <?php } ?>
              
          </select>
        </div>
      </div>

        <div class="col-md-2 form-group">
          <input class="datepicker form-control start-date" data-date-format="yyyy-mm-dd" placeholder="From Date" name="startDate"  autocomplete="off" value="<?php echo isset($_GET['startDate']) ? $_GET['startDate']: '';?>">
        </div>

        <div class="col-md-2 form-group">
          <input class="datepicker form-control end-date" data-date-format="yyyy-mm-dd" placeholder="To Date" name="endDate" autocomplete="off" value="<?php echo isset($_GET['endDate']) ? $_GET['endDate']: '';?>">
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-warning"  id="search" type="copies">Search</button>
            <input name="btnfilter" type="button" class="btn btn-danger" value="Clear Filter"
            onclick="javascript:window.location='index.php?p=<?php echo PLATFORM; ?>&a=<?php echo ACTION; if(isset($_GET['name']) && $_GET['name'] != '') { echo '&name='.$_GET['name'];}?>';">
            <input name="p" type="hidden" value="<?php echo PLATFORM; ?>">
            <input name="a" type="hidden" value="<?php echo ACTION; ?>">
            <?php if(isset($_GET['name']) && $_GET['name'] != '') { ?>
                <input name="name" type="hidden" value="<?php echo $_GET['name']; ?>">
            <?php } ?>
        </div>
  </form>