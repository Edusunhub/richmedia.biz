<?php
require_once('config.php');
if(isset($_REQUEST['token'])){
  //$users->sendVerifyEmail($_REQUEST['token']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sign Up</title>
  <?php include('common/head.php') ?>
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
</head>
<body class="hold-transition register-page dashboard-image">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="box box-sucess text-center">
          <div class="box-header with-border">
            <h3 class="box-title">Thankyou! Your account has been created successfully</h3>
          </div>
          <div class="box-body">
            <p>It will get activated after account manager approval</p>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include('common/footer-script.php') ?>
</body>
</html>
