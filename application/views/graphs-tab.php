<ul class="nav nav-tabs">
    <?php 
    $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
    $url = end($url_array);  
    ?>
  <li class="<?php echo ($url=="index.php?p=".PLATFORM) ? "active" : "";?>"><a href="index.php?p=<?php echo PLATFORM; ?>">All</a></li>
  <li class="<?php echo ($url=="index.php?p=".PLATFORM."&day=1") ? "active" : "";?>"><a href="index.php?p=<?php echo PLATFORM; ?>&day=1">Last 2 days</a></li>
  <li class="<?php echo ($url=="index.php?p=".PLATFORM."&day=7") ? "active" : "";?>"><a href="index.php?p=<?php echo PLATFORM; ?>&day=7">Last 7 days</a></li>
  <li class="<?php echo ($url=="index.php?p=".PLATFORM."&day=30") ? "active" : "";?>"><a href="index.php?p=<?php echo PLATFORM; ?>&day=30">Last 30 days</a></li>
</ul>