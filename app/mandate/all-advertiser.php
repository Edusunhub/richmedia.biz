<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Advertisers</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include('../common/admin-header.php') ?>
    <?php include('../common/sidebar.php') ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Advertisers</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Advertisers</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="col-md-12">
            <?php echo flashNotification() ?>
          </div>
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <div class="col-md-2">
                  <input type="text" name="key" class="form-control" placeholder="Key Words" value="<?php echo $_REQUEST['key'] ?>">
                </div>
                <input type="hidden" name="limit" value="<?php echo $_REQUEST['limit']; ?>" class="btn btn-warning">
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Wallet</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allusers=$users->getAllAdvertisersByAdmin();
              if(!empty($allusers['data'])){
                foreach ($allusers['data'] as $key => $user) {
              ?>
              <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td>$<?php echo $user['wallet'] ? number_format($user['wallet'],2) : '0'; ?></td>
                <td>
                  <?php
                  if($user['status']==1){
                    echo '<small class="label bg-green">Active</small>';
                  }else{
                    echo '<small class="label bg-red">Inactive</small>';
                  }
                  ?>
                </td>
              </tr>
              <?php
                }
              }else{
                echo '<tr><td colspan="6">No data found</td></tr>';
              }
              ?>
            </tbody>
          </table>
          <div class="row" style="margin:2px 0 !important;">
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
          <?php echo $allusers['pagination'] ?>
          </div>
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
    $('#reports-table').DataTable({
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