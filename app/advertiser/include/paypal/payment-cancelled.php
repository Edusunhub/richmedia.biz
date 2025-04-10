<?php
require_once('../../config.php');
require_once('../session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Payment Success</title>
  <?php include('../../common/head.php') ?>
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Campaign';
  $breadcrumbdata=array(
    0=>array(
      'link'=>'dashboard.php',
      'name'=>'Home'
    ),
    1=>array(
      'link'=>'',
      'name'=>'Create Campaign'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
  <?php include('../../common/advertiser-header.php') ?>
  <?php include('../../common/sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
      
    <!-- Main content -->
    <section class="content">
      <div class="white-layer">
        <h4 class="white-layer-title"></h4>
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="white-box">
              <div class="col-md-12">
                <?php echo flashNotification() ?>
              </div>

              <div class="row">
                <div class="col-sm-12 text-center">
                  <h2 class="mt-5 mb-5 text-red">Transaction Failed!</h2>
                  <p>Please retry again.</p>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php //include('../common/footer.php') ?>
</div>
<?php include('../../common/footer-script.php') ?>
</body>
</html>
