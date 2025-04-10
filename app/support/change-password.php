<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['changepassword'])){
  $users->changepassword();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Profile</title>
  <?php include('../common/head.php') ?>
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Profile';
  $breadcrumbdata=array(
    0=>array(
      'link'=>'dashboard.php',
      'name'=>'Home'
    ),
    1=>array(
      'link'=>'profile.php',
      'name'=>'Profile'
    ),
    2=>array(
      'link'=>'',
      'name'=>'Change Password'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
  <?php include('../common/admin-header.php') ?>
  <?php include('../common/sidebar.php') ?>
    <!-- Main content -->
    <section class="content">
      <div class="white-wapper">
        <div class="white-layer-none">
          <div class="row">
            <div class="col-md-12">
              <div class="tab-box">
                <div class="tab">
                  <a href="profile.php">Profile Details</a>
                </div>
                <div class="tab">
                  <a href="change-password.php" class="active">Change Password</a>
                </div>
              </div>              
            </div>
          </div>
          <div class="gray-box">
            <?php
            $current_user=$users->get_current_user();
            ?>
            <?php echo flashNotification() ?>
            <form method="post" class="theme-fields-form" enctype="multipart/form-data">
              <br/>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label">Current Password:</label>
                      <div class="col-sm-5">
                        <input type="password" class="form-control" name="current_password">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label">New Password:</label>
                      <div class="col-sm-5">
                        <input type="password" class="form-control" name="new_password">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label">Re-Type Password:</label>
                      <div class="col-sm-5">
                        <input type="password" class="form-control" name="re_password">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-md-12 text-right">
                  <button type="submit" name="changepassword" class="btn btn-theme btn-flat">Ok</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<?php include('../common/footer.php') ?>
<?php include('../common/footer-script.php') ?>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
