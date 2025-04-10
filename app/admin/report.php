<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['report'])){
  $report=$campaign->addReport();
}
if(isset($_REQUEST['id'])){
  $report=$campaign->getCampaignByIdEncript($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>New Report</title>
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
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Price</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-sm-12">
              <?php echo flashNotification() ?>
            </div>
            <form method="post" class="form-horizontal">
              <div class="box-body">
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">IO ID</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="campaign_group" value="<?php echo $report['campaign_group'] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Impression</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="impression">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Clicks</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="clicks">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Conversions</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="conversions">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">CTR</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ctr">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Unit Price</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="unit_price">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Spent</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="spent">
                  </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" name="report" class="btn btn-info">Save</button>
                    <input type="hidden" class="form-control" name="campaign_id" value="<?php echo $report['id'] ?>">
                    <input type="hidden" class="form-control" name="user_id" value="<?php echo $report['created_by'] ?>">
                    <input type="hidden" class="form-control" name="name" value="<?php echo $report['name'] ?>">
                    <input type="hidden" class="form-control" name="type" value="<?php echo $report['type'] ?>">
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
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