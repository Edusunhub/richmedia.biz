<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['id'])){
  $browser=$browsers->getbrowserByEncryptID($_REQUEST['id']);
}
if(empty($browser)){
  include('404.php');
  die();
}
if(isset($_POST['save'])){
  $browsers->update($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Browsers</title>
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
      <h1>Browsers</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="all-browsers.php">Browsers</a></li>
        <li class="active">Edit Browsers</li>
      </ol>
    </section>
    <?php echo flashNotification() ?>

    <section class="content">
      <!-- Default box -->
      <div class="row">
        <div class="col-md-offset-3 col-md-6">
          <div class="box">
            <div class="box-header text-center">
              <h3 class="box-title">Edit Browsers</h3>
              <hr/>
            </div>
            <div class="box-body">
              <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" required name="name" placeholder="Browser Name" value="<?php echo $browser['name'] ?>">
                </div>
                <div class="form-group">
                  <label>Os Names</label>
                  <?php
                  $osnameset=[];
                  $osnameset=explode(",",$browser['osid']);
                  ?>
                  <select multiple name="osid[]" class="form-control" required>
                    <?php
                    $allos=$os->all();
                    if(!empty($allos)){
                      foreach ($allos as $key => $osvalue) {
                    ?>
                        <option <?php echo in_array($osvalue['id'],$osnameset) ? 'selected' : '' ?> value="<?php echo $osvalue['id'] ?>"><?php echo $osvalue['name'] ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option <?php echo selectOption($browser['status'],1) ?> value="1">Active</option>
                    <option <?php echo selectOption($browser['status'],0) ?> value="0">Inactive</option>
                  </select>
                </div>
                <button type="submit" name="save" class="btn btn-warning pull-right">Save</button>
                <a href="all-browsers.php" class="btn btn-default">Back</a>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </section>
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
