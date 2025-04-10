<?php if(!empty($_SESSION['llogged'])){ ?>
<div class="loginas-bar row">
  <div class="col-md-12">
    <i class="fa fa-warning"></i>&nbsp;&nbsp;
    <?php
    echo '<strong>'.$_SESSION['lname'].'</strong> logged in as : ';
    if(empty($_SESSION['name'])){
      echo '<strong>User</strong>';
    }else{
      echo '<strong>'.$_SESSION['name'].'</strong>';
    }
    ?>
  </div>
</div>
<?php } ?>
<header class="top-header-advertiser">
<a href="<?php echo baseurl ?>" class="logo">
  <img src="<?php echo baseurl.'/images/logo.png' ?>">
</a>
<div class="navbar-custom-menu pull-right">
  <ul class="nav navbar-nav user-menu-dropdown">
    <li class="head-right-border">
      <?php $managers=$managersobj->getManagerByID($_SESSION['managerid']); ?>
      <a class="head-color">
        Account Manager :
        <?php echo '<strong>&nbsp;&nbsp;'.$managers['name'].'</strong>'; ?>
      </a>
    </li>
    <li>
      <a class="head-colortwo" href="recharge-wallet.php">
        <div class="row">
          <div class="col-md-2" data-toggle="tooltip" title="Add Funds">
            <img src="<?php echo baseurl.'/images/wallet.png' ?>" class="head-img">
          </div>
          <div class="col-md-10 mt-2">
            <span data-toggle="tooltip" title="Active Wallet Balance">
              <small class="fa fa-check-square-o"></small> 
              <?php echo "<strong>$ ".number_format($payments->availableWalletAmount(),2)."</strong>"; ?>
            </span>
             | 
            <span data-toggle="tooltip" title="Used Wallet Balance" class="text-red">
              <small class="fa fa-hourglass-2"></small> <strong>$<?php echo number_format($payments->usedWalletAmount(),2) ?></strong>
            </span>
          </div>
        </div>
      </a>
    </li>
    <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" class="head-color">
        <?php
        $cuser=$users->get_current_user();
        if(!empty($cuser['photo'])){
        ?>
          <img src="<?php echo baseurl.'/images/profile/'.$cuser['photo'] ?>" class="head-img" style="height: 26px;max-width: 41px;">
        <?php }else{ ?>
          <img src="<?php echo baseurl.'/images/user.png' ?>" class="head-img">
        <?php } ?>
        <span class="hidden-xs"><?php echo $_SESSION['name'] ? $_SESSION['name'] : 'User' ?></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Menu Footer-->
        <!--<li class="dropdown tasks-menu">
          <a class="label label-danger">
            <i class="fa fa-dollar"></i>
            <strong>
              <?php
              $wallet=$users->getUser($_SESSION['userid']);
              echo $wallet['wallet'] ? $wallet['wallet'] : '0';
              ?>
            </strong>
          </a>
        </li>-->
        <li class="user-footer">
          <div class="pull-left">
            <a href="<?php echo baseurl ?>/advertiser/profile.php" class="btn btn-default btn-flat">Profile</a>
          </div>
          <div class="pull-right">
            <a href="<?php echo baseurl ?>/signout.php" class="btn btn-default btn-flat">Sign out</a>
          </div>
        </li>
      </ul>
    </li>
  </ul>
</div>
</header>
<header class="main-header">
  <!-- Logo -->
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
    <h4 class="header-title"><?php echo $title ?></h4>

    <div class="navbar-custom-menu">
      <?php /* ?>
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success">4</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 4 messages</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li><!-- start message -->
                  <a href="#">
                    <div class="pull-left">
                      <img src="<?php echo baseurl ?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Support Team
                      <small><i class="fa fa-clock-o"></i> 5 mins</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <!-- end message -->
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="<?php echo baseurl ?>/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      AdminLTE Design Team
                      <small><i class="fa fa-clock-o"></i> 2 hours</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="<?php echo baseurl ?>/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Developers
                      <small><i class="fa fa-clock-o"></i> Today</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="<?php echo baseurl ?>/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Sales Department
                      <small><i class="fa fa-clock-o"></i> Yesterday</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="<?php echo baseurl ?>/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Reviewers
                      <small><i class="fa fa-clock-o"></i> 2 days</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="footer"><a href="#">See All Messages</a></li>
          </ul>
        </li>
        <!-- Notifications: style can be found in dropdown.less -->
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning">10</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 10 notifications</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li>
                  <a href="#">
                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                    page and may cause design problems
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-users text-red"></i> 5 new members joined
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-user text-red"></i> You changed your username
                  </a>
                </li>
              </ul>
            </li>
            <li class="footer"><a href="#">View all</a></li>
          </ul>
        </li>
        <!-- Tasks: style can be found in dropdown.less -->
        <li class="dropdown tasks-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-flag-o"></i>
            <span class="label label-danger">9</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 9 tasks</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li><!-- Task item -->
                  <a href="#">
                    <h3>
                      Design some buttons
                      <small class="pull-right">20%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">20% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
                <!-- end task item -->
                <li><!-- Task item -->
                  <a href="#">
                    <h3>
                      Create a nice theme
                      <small class="pull-right">40%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">40% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
                <!-- end task item -->
                <li><!-- Task item -->
                  <a href="#">
                    <h3>
                      Some task I need to do
                      <small class="pull-right">60%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">60% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
                <!-- end task item -->
                <li><!-- Task item -->
                  <a href="#">
                    <h3>
                      Make beautiful transitions
                      <small class="pull-right">80%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">80% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
                <!-- end task item -->
              </ul>
            </li>
            <li class="footer">
              <a href="#">View all tasks</a>
            </li>
          </ul>
        </li>
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo baseurl ?>/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
            <span class="hidden-xs">Alexander Pierce</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo baseurl ?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

              <p>
                Alexander Pierce - Web Developer
                <small>Member since Nov. 2012</small>
              </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
              <div class="row">
                <div class="col-xs-4 text-center">
                  <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Friends</a>
                </div>
              </div>
              <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo baseurl ?>/advertiser/profile.php" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo baseurl ?>/signout.php" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
      <?php */ ?>
      <?php if(!empty($breadcrumbdata)) { ?>
      <ol class="breadcrumb-links">
        <?php foreach ($breadcrumbdata as $key => $breadcrumb) { ?>
          <?php
          echo $breadcrumb['link'] ? '<li><a href="'.$breadcrumb['link'].'">'.$breadcrumb['name'].'</a></li>' : '<li class="active">'.$breadcrumb['name'].'</li>';
          ?>
          <?php } ?>
      </ol>
      <?php } ?>
    </div>
  </nav>
</header>

<div id="mobilescreen" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        This platform is preferably used in Desktops, Tabs or Laptops.
      </div>
    </div>
  </div>
</div>