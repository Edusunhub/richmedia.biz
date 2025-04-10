<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['id'])){
  $device=$devices->getDeviceByEncryptID($_REQUEST['id']);
}
if(empty($device)){
  include('404.php');
  die();
}
if(isset($_POST['save'])){
  $devices->update($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Device Types</title>
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
      <h1>Device Types</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="all-device-types.php">Device Types</a></li>
        <li class="active">Edit Device Type</li>
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
              <h4>Edit Device Type</h4>
              <hr/>
            </div>
            <div class="box-body">
              <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $device['name'] ?>">
                </div>
                <div class="form-group">
                  <label>Icon</label>
                  <input type="file" class="form-control" name="icon">
                  <?php if(!empty($device['icon'])){ ?>
                    <img src="<?php echo baseurl.'/public/uploads/'.$device['icon'] ?>" width="160">
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                    <option value="1" <?php echo selectOption($device['status'],1) ?> >Active</option>
                    <option value="0" <?php echo selectOption($device['status'],0) ?> >Inactive</option>
                  </select>
                </div>
                <button type="submit" name="save" class="btn btn-warning pull-right">Save</button>
                <a href="all-device-types.php" class="btn btn-default">Back</a>
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
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
