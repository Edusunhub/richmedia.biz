<?php
require_once('../config.php');
require_once('session.php');
if($_REQUEST['token']){
  $ad=$users->getUserByEncriptID($_REQUEST['token']);
  if(empty($ad)){
    redirect('all-advertiser.php');
  }
}
if(isset($_POST['loginas'])){
  $users->loginAs();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login As</title>
  <?php include('../common/head.php') ?>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-box-body">
    <h2 class="login-box-msg">Login As</h2>
    <div class="register-logo">
      <img src="../images/Sign_Up.png" width="150">
    </div>
    <?php echo flashNotification() ?>
    <form method="post" id="forgot-password">
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" name="loginas" class="btn btn-default btn-block btn-flat">Continue</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
<?php include('../common/footer-script.php') ?>
</body>
</html>