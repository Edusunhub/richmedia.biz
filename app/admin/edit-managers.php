<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['id'])){
  $manager=$managersobj->getManagerByEncryptID($_REQUEST['id']);
}
if(empty($manager)){
  include('404.php');
  die();
}
if(isset($_POST['save'])){
  $managersobj->update($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Edit Manager</title>
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
      <h1>Manager</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="add-managers.php">Manager</a></li>
        <li class="active">Edit Manager</li>
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
              <h4>Edit Manager</h4>
              <hr/>
            </div>
            <div class="box-body">
              <form role="form" method="post">
                <div class="form-group">
                  <label>Manager Name</label>
                  <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo $manager['name'] ?>">
                </div>
                <div class="form-group">
                  <label>Email Id</label>
                  <input type="email" class="form-control" placeholder="Email Id" name="email" value="<?php echo $manager['email'] ?>" required>
                </div>
                <div class="form-group">
                  <label>Phone Number</label>
                  <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="<?php echo $manager['phone'] ?>" required>
                </div>
                <div>
                  <input type="checkbox" name="passwordcheck" id="passwordcheck" value="1">
                  <label for="passwordcheck">Change Password</label>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" minlength="6" required name="password" placeholder="Password">
                  </div>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                    <option value="1" <?php echo selectOption($manager['status'],1) ?>>Active</option>
                    <option value="0" <?php echo selectOption($manager['status'],0) ?>>Inactive</option>
                  </select>
                </div>
                <button type="submit" name="save" class="btn btn-warning pull-right">Save</button>
                <a href="add-managers.php" class="btn btn-default">Back</a>
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
<style type="text/css">
input#passwordcheck+label+.form-group {
  display: none;
}
input#passwordcheck:checked+label+.form-group {
    display:block;
}
</style>
</body>
</html>
