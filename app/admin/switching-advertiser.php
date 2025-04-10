<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['delete'])){
  $users->deleteUser($_REQUEST['delete']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Switching Advertiser</title>
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
      <h1>Switching Advertiser</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Switching Advertiser</li>
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
          <h2>All Managers</h2>

          <table  class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allusers=$users->getManagers();
              if(!empty($allusers['data'])){
                foreach ($allusers['data'] as $key => $user) {
              ?>
              <tr>
                <td><?php echo $user['name'] ?></td>
                <td>
                  <?php
                  if($user['deleted_at']==NULL){
                    if($user['status']==1){
                      echo '<small class="label bg-green">Active</small>';
                    }else{
                      echo '<small class="label bg-yellow">Inactive</small>';
                    }
                  }else{
                    echo '<small class="label bg-red">Deleted</small>';
                  }
                  ?>
                </td>
                <td>
                  <a href="manage-advertiser.php?manager=<?php echo md5($user['id']); ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-eye"></i>
                  </a>
                </td>
              </tr>
              <?php
                }
              }else{
                echo '<tr><td colspan="8">No data found</td></tr>';
              }
              ?>
            </tbody>
          </table>
          <?php echo $allusers['pagination'] ?>
        </div>
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