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
$expired=$users->checkRestToken($_REQUEST['auth']);
if(isset($_POST['change'])){
  $users->resetPassword($_REQUEST['auth']);
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
    <?php if($expired): ?>
      <h2 class="login-box-msg">Reset Password</h2>
      <div class="register-logo">
        <img src="images/Sign_Up.png" width="150">
      </div>
      <?php echo flashNotification() ?>
    
      <form method="post" id="forgot-password">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Token" name="token" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" name="change" class="btn btn-default btn-block btn-flat">Reset</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    <?php else: ?>
      <div class="alert alert-danger">Sorry!, You password reset request has been expired</div>      
    <?php endif ?>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
<?php include('common/footer-script.php') ?>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $.validator.addMethod("pwcheck", function(value) {
    return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
    && /[a-z]/.test(value) // has a lowercase letter
    && /\d/.test(value) // has a digit
  });
  $('#forgot-password').validate({
    rules : {
      password : {
        minlength: 6,
        pwcheck: true
      },
      cpassword: {
        equalTo: "#password"
      }
    },
    messages : {
      password : {
        pwcheck : 'Your password is not strong'
      }
    },
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