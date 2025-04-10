<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['save'])){
  $users->addMandate();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mandate</title>
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
      <h1>Add Mandate</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="all-mandate.php">All Mandates</a></li>
        <li class="active">Add Mandate</li>
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
          <form class="forms-sample" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" required name="name" placeholder="Name">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" required name="email" placeholder="Email">
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" class="form-control" name="phone" placeholder="Phone">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" minlength="6" required name="password" placeholder="Password">
            </div>
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
            <button type="submit" name="save" class="btn btn-warning pull-right">Save</button>
            <a href="all-mandate.php" class="btn btn-default">Back</a>
          </form>
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $('form').validate({
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).parents('.form-group').data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        $(element).parents('.form-group').append(error);
      }
    }
  });
</script>
</body>
</html>
