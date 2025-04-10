<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campaigns</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
  <div class="content-wrapper">
  <?php include('../common/admin-header.php') ?>
  <?php include('../common/sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Reports</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="col-md-12">
          <?php echo flashNotification() ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="ostype-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>id</th>
                <th>IO ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Device</th>
                <th>Country</th>
                <th>Min. Bid</th>
                <th>Max. Bid</th>
                <th style="width: 170px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $campaigns=$campaign->getAllActiveCampaignsByGroupId($_REQUEST['id']);
              if(!empty($campaigns)){
                foreach ($campaigns as $key => $camp) {
              ?>
              <tr>
                <td><?php echo $camp['id']; ?></td>
                <td>#<?php echo $camp['campaign_group']; ?></td>
                <td><?php echo $camp['name']; ?></td>
                <td><?php echo $camp['type']; ?></td>
                <td>
                  <?php
                  $device=json_decode($camp['device']);
                  echo implode(',', $device);
                  ?>
                </td>
                <td>
                  <?php
                  $country=$common->countriesByID($camp['country']);
                  echo $country['name'];
                  ?>
                </td>
                <td><?php echo $camp['min_bid']; ?></td>
                <td><?php echo $camp['max_bid']; ?></td>
                <td>
                  <a href="add-report.php?id=<?php echo md5($camp['id']) ?>" data-toggle="tooltip" title="Add Report" class="btn btn-sm btn-default">
                    <i class="fa fa-calculator"></i>
                  </a>
                </td>
              </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('../common/footer.php') ?>  
</div>
<?php include('../common/footer-script.php') ?>
<!-- DataTables -->
<script src="<?php echo baseurl ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo baseurl ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#ostype-table').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
