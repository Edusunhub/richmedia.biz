<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['id'])){
  $model=$models->getModelByEncryptID($_REQUEST['id']);
}
if(empty($model)){
  include('404.php');
  die();
}
if(isset($_POST['save'])){
  $models->update($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campaign Model Types</title>
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
      <h1>Campaign Models</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="model-types.php">Campaign Models</a></li>
        <li class="active">Edit Campaign Model</li>
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
              <h4>Edit Model Type</h4>
              <hr/>
            </div>
            <div class="box-body">
              <form role="form" method="post">
                <div class="form-group">
                  <label>Model Name</label>
                  <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo $model['name'] ?>">
                </div>
                <div class="form-group">
                  <label>Type</label>
                    <select name="type" class="form-control">
                      <option value="Banner" <?php echo selectOption('Banner',$model['type']) ?>>Banner</option>
                      <option value="Push" <?php echo selectOption('Push',$model['type']) ?>>Push</option>
                      <option value="Pop" <?php echo selectOption('Pop',$model['type']) ?>>POP</option>
                      <option value="Video" <?php echo selectOption('Video',$model['type']) ?>>Video</option>
                      <option value="Native" <?php echo selectOption('Native',$model['type']) ?>>Native</option>
                    </select>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                    <option value="1" <?php echo selectOption($model['status'],1) ?>>Active</option>
                    <option value="0" <?php echo selectOption($model['status'],0) ?>>Inactive</option>
                  </select>
                </div>
                <button type="submit" name="save" class="btn btn-warning pull-right">Save</button>
                <a href="model-types.php" class="btn btn-default">Back</a>
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
