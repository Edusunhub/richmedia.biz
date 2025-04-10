<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['delete'])){
  $users->deleteStaff($_REQUEST['delete']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Staff</title>
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
      <h1>Manage Support Staffs</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Support Staffs</li>
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
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <div class="col-md-2">
                  <input type="text" name="key" class="form-control" placeholder="Key Words" value="<?php echo $_REQUEST['key'] ?>">
                </div>
                <div class="col-md-2">
                  <select name="status" class="form-control">
                    <option value="">Status</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'1') ?> value="1">Active</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'0') ?> value="0">Inactive</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
            <div class="col-md-2 text-right">
              <a href="add-staff.php" class="btn btn-default">Add Support Staff</a>
            </div>
          </div>
          <br/>
          <table  class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allusers=$users->getAllStaffs();
              if(!empty($allusers['data'])){
                $i=1;
                foreach ($allusers['data'] as $key => $user) {
              ?>
              <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['phone']; ?></td>
                <td>
                  <?php
                  if($user['status']==1){
                    echo '<span class="badge bg-green">Active</span>';
                  }else{
                    echo '<span class="badge bg-red">Inactive</span>';
                  }
                  ?>
                </td>
                <td>
                  <a href="edit-staff.php?id=<?php echo md5($user['id']); ?>" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>
                  <a onclick="return confirm('Are you sure?')" href="all-staff.php?delete=<?php echo md5($user['id']); ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php
              $i++;
                }
              }else{
                echo '<tr><td colspan="6">No data found</td></tr>';
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
