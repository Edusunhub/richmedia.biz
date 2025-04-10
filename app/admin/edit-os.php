<?php
require_once('../config.php');
require_once('session.php');
if($_REQUEST['id']){
  $ostype=$os->getOSypeByEncryptID($_REQUEST['id']);
}
if(empty($ostype)){
  include('404.php');
  die();
}
if(isset($_POST['save'])){
  $os->updateOS($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OS Types</title>
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
      <h1>OS Types</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="os-types.php">OS Types</a></li>
        <li class="active">Edit OS</li>
      </ol>
    </section>
    <?php echo flashNotification() ?>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="row">
        <div class="col-md-offset-3 col-md-6">
          <div class="box">
            <div class="box-header text-center">
              <h3 class="box-title">Edit OS</h3>
              <hr/>
            </div>
            <div class="box-body">
              <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" required id="osname" name="name" placeholder="OS Name" value="<?php echo $ostype['name'] ?>">
                </div>
                <div class="form-group">
                  <label>Devices</label>
                  <?php
                  $osdeviceset=[];
                  $osdeviceset=explode(",",$ostype['deviceid']);
                  ?>
                  <select multiple name="devices[]" class="form-control" required>
                    <?php
                    $alldevices=$devices->getAllDevice();
                    if(!empty($alldevices)){
                      foreach ($alldevices as $key => $device) {
                    ?>
                        <option <?php echo in_array($device['id'], $osdeviceset) ? 'selected' : '' ?> value="<?php echo $device['id'] ?>"><?php echo $device['name'] ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="1" <?php echo selectOption(1,$ostype['status']) ?>>Active</option>
                    <option value="0" <?php echo selectOption(0,$ostype['status']) ?>>Inactive</option>
                  </select>
                </div>
                <input type="hidden" name="token" value="<?php echo $ostype['id'] ?>">
                <button type="submit" name="save" class="btn btn-warning pull-right">Save</button>
                <a href="os-types.php" class="btn btn-default">Back</a>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box -->
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
