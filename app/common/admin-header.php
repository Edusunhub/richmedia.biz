<?php
$ncount=$common->getNotificationCount();
?>
<header class="top-header-advertiser">
<a href="<?php echo baseurl ?>" class="logo">
  <img src="<?php echo baseurl.'/images/logo.png' ?>">
</a>
<div class="navbar-custom-menu pull-right">
  <ul class="nav navbar-nav user-menu-dropdown">
    <?php if($_SESSION['type']!=3){ ?>
    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning"><?php echo $ncount ?></span>
      </a>
      <ul class="dropdown-menu">
        <li class="header">You have <?php echo $ncount ?> notifications</li>
        <li>
          <ul class="menu">
            <?php
            $notifications=$common->getNotifications(10,1);
            
            if(!empty($notifications['data'])){
              foreach ($notifications['data'] as $key => $noti) {
                if($noti['type']==1){
                  $link='view-campaign.php?id='.md5($noti['campaign_id']).'&from=notification&noteid='.md5($noti['id']);
                }
            ?>
                <li>
                  <a href="<?php echo $link ?>">
                    <i class="fa fa-file text-yellow"></i> <?php echo $noti['note'] ?>
                  </a>
                </li>
            <?php
              }
            }
            ?>
          </ul>
        </li>
        <li class="footer"><a href="all-notifications.php">View all</a></li>
      </ul>
    </li>
  <?php } ?>

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
        <span class="hidden-xs"><?php echo $cuser['name'] ? $cuser['name'] : 'User' ?></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="pull-left">
            <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
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