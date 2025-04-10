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
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php include('../common/header.php') ?>
  <?php include('../common/sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Campaigns</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Campaign</li>
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
            <tbody>
              <?php
              $camp=$campaign->getCampaignByIdEncript($_REQUEST['id']);
              ?>
              <tr>
                <td>Campaign ID</td>
                <td>#<?php echo $camp['campaign_group']; ?></td>
              </tr>
              <tr>
                <td>Type</td>
                <td><?php echo $camp['type']; ?></td>
              </tr>
              <tr>
                <td>OS</td>
                <td>
                  <?php
                  $osid=explode(',', $camp['os']);
                  foreach ($osid as $key => $id) {
                    $detail=$os->getOSByID($id);
                    $osdetail[]=$detail['name'];
                  }
                  echo implode(',', $osdetail);
                  ?>
                </td>
              </tr>
              <tr>
                <td>Devices</td>
                <td>
                  <?php
                  $device=json_decode($camp['device']);
                  echo implode(',', $device);
                  ?>
                </td>
              </tr>
              <tr>
                <td>Browser</td>
                <td><?php echo $camp['browser']; ?></td>
              </tr>
              <tr>
                <td>Language</td>
                <td><?php echo $camp['language']; ?></td>
              </tr>
              <tr>
                <td>ISP</td>
                <td><?php echo $camp['isp']; ?></td>
              </tr>
              <tr>
                <td>Connection</td>
                <td><?php echo $camp['connection']; ?></td>
              </tr>
              <tr>
                <td>Image</td>
                <td><?php echo $camp['image'] ? '<img src="'.baseurl.'/images/banner/'.$camp['image'].'"' : '' ; ?></td>
              </tr>
              <tr>
                <td>URL</td>
                <td><?php echo $camp['url']; ?></td>
              </tr>
              <tr>
                <td>JS Tags</td>
                <td><?php echo $camp['js_tag']; ?></td>
              </tr>
              <tr>
                <td>Start Date</td>
                <td><?php echo $camp['startdate']; ?></td>
              </tr>
              <tr>
                <td>End Date</td>
                <td><?php echo $camp['enddate']; ?></td>
              </tr>
              <tr>
                <td>Country</td>
                <td>
                  <?php
                  $country=$common->countriesByID($camp['country']);
                  echo $country['name'];
                  ?>
                </td>
              </tr>
              <tr>
                <td>Min. Bid</td>
                <td><?php echo $camp['min_bid']; ?></td>
              </tr>
              <tr>
                <td>Max. Bid</td>
                <td><?php echo $camp['max_bid']; ?></td>
              </tr>
              <tr>
                <td>Total Budget <small>(USD)</small></td>
                <td><?php echo $camp['total_budget']; ?></td>
              </tr>
              <tr>
                <td>Daily Amount <small>(USD)</small></td>
                <td><?php echo $camp['daily_amount']; ?></td>
              </tr>
              <tr>
                <td>Frequency cap 24 hours</td>
                <td><?php echo $camp['cap']; ?></td>
              </tr>
              <tr>
                <td>Status</td>
                <td>
                  <?php
                  $status=array(1=>array('label'=>'Active','class'=>'bg-green'),2=>array('label'=>'Inactive','class'=>'bg-red'));
                  echo '<small class="label '.$status[$camp['status']]['class'].'">';
                  echo $status[$camp['status']]['label'];
                  echo '</small>';
                  ?>                    
                </td>
              </tr>
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
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
