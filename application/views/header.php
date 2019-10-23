<nav class="navbar navbar-inverse navbar-static-top" data-spy="affix" data-offset-top="197">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" style="padding: 5px;"><img src="public/images/netapp.png" style="height: 40px;"/></a>
      <a class="navbar-brand" href="#" style="padding: 5px;background-color:white;"><img src="public/images/nse_logo.png" style="height: 40px;"/></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Log Management Dashboard</a></li>
      <!--<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
      <li><a href="#">Page 2</a></li>-->
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-th-list"></span> OnCommand Tools <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class =" dropdown dropdown-submenu">
            <a href="#" class="test" data-toggle="dropdown" class="droptown-toggle">OnCommand Workflow Automation<span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li>
                    <a href="#">BKC</a>
                </li>
                <li>
                    <a href="#">BCP</a>
                </li>              
              </ul>
          </li>
          <li class ="dropdown dropdown-submenu">
            <a href="#" class="test" data-toggle="dropdown" class="droptown-toggle">OnCommand System Manager<span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li>
                    <a href="#">BKC</a>
                </li>
                <li>
                    <a href="#">BCP</a>
                </li>              
              </ul>
          </li>
          <li class ="dropdown dropdown-submenu">
            <a href="#" class="test" data-toggle="dropdown" class="droptown-toggle">OnCommand Unified Manager<span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li>
                    <a href="#">BKC</a>
                </li>
                <li>
                    <a href="#">BCP</a>
                </li>              
              </ul>
          </li>          
        </ul>
      </li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Portal Link</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo isset($_SESSION['user'])? $_SESSION['user']: '';?> <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="index.php?p=auth&a=signout">Sign Out</a></li>
        </ul>
      </li>
      <!-- <li><a href="index.php?p=auth&a=signout"><span class="glyphicon glyphicon-user"></span> Sign Out</a></li> -->
    </ul>
  </div>
</nav>