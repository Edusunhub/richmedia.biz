<?php
require_once('../config.php');
require_once('session.php');
//$campaigns=$campaign->getAllCampaignsByEncriptGroupId($_REQUEST['id']);
if(isset($_POST['report'])){
  $report=$campaign->updateReport($_REQUEST['id']);
}
if(isset($_REQUEST['id'])){
  $report=$campaign->report($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reports</title>
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
        <div class="box-body">
          <form method="post" class="form-horizontal">
            <div class="box-header">
              <h3 class="box-title">Add Report</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label class="col-sm-3 control-label">Impression</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="impression" value="<?php echo $report['impression'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Clicks</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="clicks" value="<?php echo $report['clicks'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Conversions</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="conversions" value="<?php echo $report['conversions'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">CTR</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="ctr" value="<?php echo number_format($report['ctr'],3); ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Unit Price</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="unit_price" value="<?php echo number_format($report['unit_price'],2); ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Spent</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="spent" value="<?php echo number_format($report['spent'],2); ?>">
                </div>
              </div>
              <div class="form-group text-center">
                  <button type="submit" name="report" class="btn btn-info">Save</button>
                  <input type="hidden" class="form-control" name="user_id" value="<?php echo $report['user_id'] ?>">
                  <input type="hidden" class="form-control" name="campaign_id" value="<?php echo $report['campaign_id'] ?>">
                  <input type="hidden" class="form-control" name="type" value="<?php echo $report['type'] ?>">
              </div>
            </div>
            <!-- /.box-footer -->
          </form>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('../common/footer.php') ?>  
</div>
<?php include('../common/footer-script.php') ?>
</body>
</html>