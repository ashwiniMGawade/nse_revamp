<div class="panel with-nav-tabs panel-primary nav-fill">
  <div class="panel-heading">
    <ul class="nav nav-tabs">
        <?php 
        $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
        $url = end($url_array);  
        $name = '';
        if(isset($_GET['name']) && !empty($_GET["name"])) {
          $name = "";
          foreach($_GET['name'] as $server_name) {
              $name .= "&name[]=".$server_name;
          }
        };
        $server = isset($_GET['a']) && $_GET["a"] != '' ? "&a=". $_GET["a"] : '';
        ?>
      <li class="<?php echo ($url=="index.php?p=".PLATFORM.$server.$name) ? "active" : "";?>"><a href="index.php?p=<?php echo PLATFORM.$server.$name; ?>">All</a></li>
      <li class="<?php echo ($url=="index.php?p=".PLATFORM.$server.$name."&day=1") ? "active" : "";?>"><a href="index.php?p=<?php echo PLATFORM.$server.$name; ?>&day=1">Last 2 days</a></li>
      <li class="<?php echo ($url=="index.php?p=".PLATFORM.$server.$name."&day=7") ? "active" : "";?>"><a href="index.php?p=<?php echo PLATFORM.$server.$name; ?>&day=7">Last 7 days</a></li>
      <li class="<?php echo ($url=="index.php?p=".PLATFORM.$server.$name."&day=30") ? "active" : "";?>"><a href="index.php?p=<?php echo PLATFORM.$server.$name; ?>&day=30">Last 30 days</a></li>
    </ul>
  </div>
</div>