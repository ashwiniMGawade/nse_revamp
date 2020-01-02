<nav class="navbar navbar-custom navbar-fixed " data-spy="affix" data-offset-top="197" style="border:none;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" style="padding: 5px;"><img src="public/images/netapp-logo-white.png" style="padding: 5px;height: 37px;"/></a>
      <a class="navbar-brand" href="#" style="padding: 5px;background-color:white;"><img src="public/images/nse_logo.png" style="height: 40px;"/></a>
    </div>
    <ul class="nav navbar-nav">
      <li class=""><a href="#">Log Management Dashboard</a></li>
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
            <a href="#" class="test" data-toggle="dropdown" class="droptown-toggle"><span class="glyphicon glyphicon-tasks"></span>  OnCommand Workflow Automation<span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li>
                    <a href="#" target="_blank">BKC</a>
                </li>
                <li>
                    <a href="#" target="_blank">BCP</a>
                </li>              
              </ul>
          </li>
          <li class ="dropdown dropdown-submenu">
            <a href="#" class="test" data-toggle="dropdown" class="droptown-toggle"><span class="glyphicon glyphicon-cog"></span>  OnCommand System Manager<span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li>
                    <a href="https://172.20.228.57/sysmgr/" target="_blank">BKC</a>
                </li>
                <li>
                    <a href="https://172.24.228.75/sysmgr/" target="_blank">BCP</a>
                </li>              
              </ul>
          </li>
          <li class ="dropdown dropdown-submenu">
            <a href="#" class="test" data-toggle="dropdown" class="droptown-toggle"><span class="glyphicon glyphicon-briefcase"></span>	 OnCommand Unified Manager<span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li>
                    <a href="#" target="_blank">BKC</a>
                </li>
                <li>
                    <a href="#" target="_blank">BCP</a>
                </li>              
              </ul>
          </li>          
        </ul>
      </li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Portal Link</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo isset($_SESSION['user'])? $_SESSION['user']: '';?> <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="index.php?p=auth&a=signout"><span class="glyphicon glyphicon-off"></span> Sign Out</a></li>
        </ul>
      </li>
      <!-- <li><a href="index.php?p=auth&a=signout"><span class="glyphicon glyphicon-user"></span> Sign Out</a></li> -->
    </ul>
  </div>
</nav>