<?php
require_once('config.php');
if(isset($_SESSION['logged'])){
  $type=$_SESSION['type'];
  if($type==1){
    redirect('advertiser/dashboard.php');
  }elseif($type==5){
    redirect('support/dashboard.php');
  }else{
    redirect('admin/dashboard.php');
  }
}
if(isset($_POST['forgotpassword'])){
  $users->sendNewPasswordLink($_POST['email']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Forgot Password</title>
  <?php include('common/head.php') ?>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-box-body">
    <h2 class="login-box-msg">Reset Password</h2>
    <div class="register-logo">
      <img src="images/Sign_Up.png" width="150">
    </div>
    <?php echo flashNotification() ?>
    <form method="post" id="forgot-password">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" name="forgotpassword" class="btn btn-default btn-block btn-flat">Continue</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
<?php include('common/footer-script.php') ?>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $('#forgot-password').validate({
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
