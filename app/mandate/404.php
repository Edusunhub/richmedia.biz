<?php
require_once('../config.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campaign Model Types</title>
  <?php include('../common/head.php') ?>
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->

<section class="content">
  <center class="pt-5 pb-1">
    <img src="<?php echo baseurl.'/images/logo.png' ?>">
  </center>
  <div class="error-page">
    <h2 class="headline text-yellow mt-5"> 404</h2>

    <div class="error-content pt-5">
      <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

      <p>
        We could not find the page you were looking for.
        Meanwhile, you may <a href="<?php echo baseurl.'/admin' ?>">return to dashboard</a>
      </p>
    </div>
    <!-- /.error-content -->
  </div>
  <!-- /.error-page -->
</section>
<?php include('../common/footer-script.php') ?>
</body>
</html>
