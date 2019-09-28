<form name="search_frm" id="search_frm" method="get" action="index.php" enctype="multipart/form-data">  
      <div class="col-md-3">
        <div class="form-group">
          <select class="form-control" id="exampleFormControlSelect1" name="status">
            <option value="">Filter by Status</option>
            <option value="successful" <?php echo ($_GET['status'] === 'successful') ? 'selected' : '' ;?>>Successful</option>
            <option value="failed" <?php echo ($_GET['status'] === 'failed')? 'selected' : '';?>>Failed</option>
          </select>
        </div>
      </div>

        <div class="col-md-2 form-group">
          <input class="datepicker form-control start-date" data-date-format="mm/dd/yyyy" placeholder="start Date" name="startDate" value="<?php echo $_GET['startDate'];?>">
        </div>

        <div class="col-md-2 form-group">
          <input class="datepicker form-control end-date" data-date-format="mm/dd/yyyy" placeholder="end Date" name="endDate" value="<?php echo $_GET['endDate'];?>">
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-warning"  id="search" type="copies">Search</button>
            <input name="btnfilter" type="button" class="btn btn-danger" value="Clear Filter"
            onclick="javascript:window.location='index.php';">
            <input name="p" type="hidden" value="<?php echo PLATFORM; ?>">
            <input name="a" type="hidden" value="<?php echo ACTION; ?>">
        </div>
  </form>