<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['save'])){
  $os->saveOSVersion();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OS Versions</title>
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
      <h1>OS Versions</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="os-versions.php"> OS Versions</a></li>
        <li class="active">New OS Version</li>
      </ol>
    </section>
    <?php echo flashNotification() ?>

    <section class="content">
      <!-- Default box -->
      <div class="row">
        <div class="col-md-offset-3 col-md-6">
          <div class="box">
            <div class="box-header text-center">
              <h3 class="box-title">Add New OS Version</h3>
              <hr/>
            </div>
            <div class="box-body">
              <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Version</label>
                  <input type="text" class="form-control" required id="osname" name="name" placeholder="Version Name">
                </div>
                <div class="form-group">
                  <label>OS Type</label>
                  <?php $oss=$os->all(); ?>
                  <select name="ostype[]" multiple="multiple" class="form-control" required>
                    <?php
                    if(!empty($oss)){
                      foreach ($oss as $key => $osval) {
                        echo '<option value="'.$osval['id'].'">'.$osval['name'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                  </select>
                </div>
                <button type="submit" name="save" class="btn btn-warning pull-right">Save</button>
                <a href="os-versions.php" class="btn btn-default">Back</a>
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