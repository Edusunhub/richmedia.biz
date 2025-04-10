<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['deactivated'])){
  $users->inactive();
}
if(isset($_REQUEST['activate'])){
  $users->activate();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Users</title>
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
      <h1>Users</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
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
          <table  class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allusers=$users->getUsers();
              if(!empty($allusers['data'])){
                foreach ($allusers['data'] as $key => $user) {
              ?>
              <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php if($user['role']==1){
                            echo '<span class="label bg-green">Admin</span>';
                          }elseif($user['role']==5) {
                            echo '<span class="label bg-green">Support</span>';
                          }elseif($user['role']==3){
                            echo '<span class="label bg-green">Manager</span>';
                          }else{
                            echo '<span class="label bg-orange">Advertisers</span>';
                          } ?></td>
                <td>
                  <?php
                  if($user['status']==1){
                    echo '<small class="label bg-green">Active</small>';
                  }else{
                    echo '<small class="label bg-red">Inactive</small>';
                  }
                  ?>
                </td>
                <td>
                  <?php if($user['status']==1){ ?>
                  <a href="?deactivated=<?php echo md5($user['id']) ?>" onclick="return confirm('Are you sure you?')" class="btn btn-sm bg-red btn-default">Inactive</a>
                  <?php }else{ ?>
                  <a href="?activate=<?php echo md5($user['id']) ?>" onclick="return confirm('Are you sure you?')" class="btn btn-sm btn-default">Active</a>
                <?php } ?>
                </td>
              </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
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
