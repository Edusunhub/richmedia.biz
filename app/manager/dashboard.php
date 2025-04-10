<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <?php include('../common/head.php') ?>
</head>
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
  <div class="content-wrapper">
  <?php include('../common/admin-header.php') ?>
  <?php include('../common/sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <?php echo flashNotification() ?>
    <!-- Main content -->
    <section class="content text-center">
      <div class="row">
        <div class="col-sm-12 col-md-4">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Pending Campaigns</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Campaign Name</th>
                      <th>Type</th>
                      <th>Budget</th>
                      <!--<th></th>-->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $pendingcampaigns=$campaign->getAllManagerWaitingCampaigns(15,$_SESSION['userid']);
                    if(!empty($pendingcampaigns)){
                      foreach ($pendingcampaigns as $key => $camp) {
                    ?>
                        <tr>
                          <td>
                            <?php $name=$users->getUser($camp['created_by']); echo $name['name']; ?>
                          </td>
                          <td><?php echo htmlspecialchars_decode($camp['name']) ?></td>
                          <td><?php echo $camp['type'] ?></td>
                          <td>$<?php echo number_format($camp['total_budget'],2); ?></td>
                          <!--<td>
                            <a href="<?php echo baseurl.'/support/view-campaign.php?id='.md5($camp['id']) ?>"><i class="fa fa-eye"></i></a>
                          </td>-->
                        </tr>
                    <?php
                      }
                    }else{
                    ?>
                      <tr>
                        <td colspan="5">No data found</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Paused Campaigns</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Campaign Name</th>
                      <th>Type</th>
                      <th>Budget</th>
                      <!--<th></th>-->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $pendingcampaigns=$campaign->getAllManagerPausedCampaigns(15,$_SESSION['userid']);
                    if(!empty($pendingcampaigns)){
                      foreach ($pendingcampaigns as $key => $camp) {
                    ?>
                        <tr>
                          <td>
                            <?php $name=$users->getUser($camp['created_by']); echo $name['name']; ?>
                          </td>
                          <td><?php echo htmlspecialchars_decode($camp['name']) ?></td>
                          <td><?php echo $camp['type'] ?></td>
                          <td><?php echo number_format($camp['total_budget'],2); ?></td>
                          <!--<td>
                            <a href="<?php echo baseurl.'/manager/view-campaign.php?id='.md5($camp['id']) ?>"><i class="fa fa-eye"></i></a>
                          </td>-->
                        </tr>
                    <?php
                      }
                    }else{
                    ?>
                      <tr>
                        <td colspan="5">No data found</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> -->
            <!-- /.box-footer -->
          </div>
        </div>
        <div class="col-sm-12 col-md-4">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Active Campaigns</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Campaign Name</th>
                      <th>Type</th>
                      <th>Budget</th>
                      <!--<th></th>-->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $pendingcampaigns=$campaign->getAllManagerActiveCampaigns(15,$_SESSION['userid']);
                    if(!empty($pendingcampaigns)){
                      foreach ($pendingcampaigns as $key => $camp) {
                    ?>
                        <tr>
                          <td>
                            <?php $name=$users->getUser($camp['created_by']); echo $name['name']; ?>
                          </td>
                          <td><?php echo htmlspecialchars_decode($camp['name']) ?></td>
                          <td><?php echo $camp['type'] ?></td>
                          <td><?php echo number_format($camp['total_budget'],2); ?></td>
                          <!--<td>
                            <a href="<?php echo baseurl.'/support/view-campaign.php?id='.md5($camp['id']) ?>"><i class="fa fa-eye"></i></a>
                          </td>-->
                        </tr>
                    <?php
                      }
                    }else{
                    ?>
                      <tr>
                        <td colspan="5">No data found</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> -->
            <!-- /.box-footer -->
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <?php include('../common/footer.php') ?>  
</div>
<?php include('../common/footer-script.php') ?>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
