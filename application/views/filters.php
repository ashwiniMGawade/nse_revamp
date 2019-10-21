<form name="search_frm" id="search_frm" method="get" action="index.php" enctype="multipart/form-data">  
      <div class="col-md-2">
        <div class="form-group font12">
          <select class="form-control font12" id="exampleFormControlSelect1" name="status" data-toggle="tooltip" title="Please select status">
            <option value="">Status</option>
            <?php  foreach($validStatusToAssign as $row) { ?>
                <option value="<?php echo $row;?>" <?php echo (isset($_GET['status']) && $_GET['status'] === $row) ? 'selected' : '' ;?>><?php echo ucfirst($row);?></option>
            <?php } ?>
              
          </select>
        </div>
      </div>

        <!-- <div class="col-md-2 form-group">
          <input class="datepicker form-control start-date" data-date-format="yyyy-mm-dd" placeholder="From Date" name="startDate"  autocomplete="off" value="<?php //echo isset($_GET['startDate']) ? $_GET['startDate']: '';?>">
        </div> -->

        <div class="form-group col-md-3">
            <div class='input-group date datepicker start-date' data-toggle="tooltip" title="From Date">
                <input type='text' class="form-control font12" name="startDate" autocomplete="off" id="startDate" placeholder="From Date"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>

        <!-- <div class="col-md-3 form-group">
          <input class="datepicker form-control end-date font12" data-date-format="yyyy-mm-dd" placeholder="To Date" name="endDate" autocomplete="off" value="<?php //echo isset($_GET['endDate']) ? $_GET['endDate']: '';?>">
        </div> -->

        <div class="form-group col-md-3">
            <div class='input-group date datepicker end-date' data-toggle="tooltip" title="To Date">
                <input type='text' class="form-control font12" name="endDate" id="endDate" autocomplete="off" placeholder="To Date"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-warning font12"  id="search" type="copies" data-toggle="tooltip" title="search">Search</button>

            <span class="btn btn-danger" onclick="javascript:window.location='index.php?p=<?php echo PLATFORM; ?>&a=<?php echo ACTION; if(isset($_GET['name']) && $_GET['name'] != '') { echo '&name='.$_GET['name'];}?>';" data-toggle="tooltip" title="Clear Filter">
              <span class="glyphicon glyphicon-erase" style="color:white;"></span>
          </span>


          
            <input name="p" type="hidden" value="<?php echo PLATFORM; ?>">
            <input name="a" type="hidden" value="<?php echo ACTION; ?>">
            <?php if(isset($_GET['name']) && $_GET['name'] != '') { ?>
                <input name="name" type="hidden" value="<?php echo $_GET['name']; ?>">
            <?php } ?>
        </div>
  </form>