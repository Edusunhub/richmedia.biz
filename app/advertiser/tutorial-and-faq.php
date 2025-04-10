<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Report</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Report';
  $breadcrumbdata=array(
    0=>array(
      'link'=>'dashboard.php',
      'name'=>'Home'
    ),
    1=>array(
      'link'=>'',
      'name'=>'Report'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
    <?php include('../common/advertiser-header.php') ?>
    <?php include('../common/sidebar.php') ?>
    <!-- Main content -->
    <section class="content text-center">

      <!-- Default box -->
      <h4 class="text-white">Hi <?php echo $_SESSION['name'] ? $_SESSION['name'] : 'User' ?></h4>
      <h1 class="mt-5 text-white">Sorry!</h1>
      <i class="text-yellow fa fa-exclamation-triangle" style="font-size: 150px;"></i>
      <!-- /.box -->
      <h4 class="text-white">This page is under construction</h4>
      <div class="row">
        <div class="col-md-2 col-sm-offset-5">
          <div class="progress progress-xs active">
            <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
              <span class="sr-only">60% Complete (warning)</span>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
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
