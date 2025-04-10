<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Countries</title>
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
      <h1>Countries</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Countries</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <div class="col-md-2">
                  <input type="text" name="key" class="form-control" placeholder="Key Words">
                </div>
                <div class="col-md-2">
                  <select name="status" class="form-control">
                    <option value="">Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                  <input type="hidden" name="limit" value="<?php echo $_REQUEST['limit'] ?>" class="btn btn-warning">
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>              
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="col-md-12">
            <?php echo flashNotification() ?>
          </div>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Sort Name</th>
                <th>Name</th>
                <th>Phone Code</th>
                <th style="width: 80px">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $countries=$common->getAllCountries();
              if(!empty($countries['data'])){
                foreach ($countries['data'] as $key => $country) {
              ?>
                  <tr>
                    <td><?php echo $country['sortname'] ?></td>
                    <td><?php echo $country['name'] ?></td>
                    <td><?php echo $country['phonecode'] ?></td>
                    <td>
                      <?php
                      $status=array(1=>'<span class="badge bg-green">Active</span>',2=>'<span class="badge bg-green">Inactive</span>');
                      echo $status[$country['status']];
                      ?>
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
        <div class="box-footer">
          <div class="row" style="margin: 2px 0 !important;">
              <div class="col-md-2" style="padding-left: 0 !important;">
                <form id="limit">
                  <select name="limit" class="form-control" onchange="this.form.submit();">
                    <option value="">no of record</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </form>
            </div>
            <?php echo $countries['pagination'] ?>
          </div>        
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

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