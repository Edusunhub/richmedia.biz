<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li>
        <a href="<?php echo baseurl ?>/advertiser/dashboard.php">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-newspaper-o"></i>
          <span>Campaigns</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="all-campaigns.php">
              <i class="fa fa-files-o"></i>
              <span>All Campaigns</span>
            </a>
          </li>
          <li>
            <a href="new-campaign.php">
              <i class="fa fa-pencil-square-o"></i>
              <span>Create Campaign</span>
            </a>
          </li>
        </ul>
      </li>
      <li>
        <a href="reports.php">
          <i class="fa fa-calculator"></i>
          <span>Reports</span>
        </a>
      </li>
      <li>
        <a href="payment.php">
          <i class="fa fa-credit-card"></i>
          <span>Payments</span>
        </a>
      </li>
      <li>
        <a href="recharge-wallet.php">
          <i class="fa fa-money"></i>
          <span>Wallet Recharge</span>
        </a>
      </li>
      <li>
        <a href="<?php echo baseurl.'/signout.php' ?>">
          <i class="fa fa-unlock"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>