<?php
require_once('../config.php');
require_once('session.php');
if(isset($_GET['find'])){
  $campaign->find($_GET['find']);
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
            <h3 class="box-title">Find Campaign</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-sm-12">
              <?php echo flashNotification() ?>
            </div>
            <form method="get" action="list-campaigns.php" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Campaign ID</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="id">
                  </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" name="find" value="true" class="btn btn-info">Find</button>
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