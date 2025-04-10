<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['walletpayment'])){
  $payments->walletPayment();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Wallet Recharge</title>
  <?php include('../common/head.php') ?>
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
      'name'=>'Wallet Recharge'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
  <?php include('../common/advertiser-header.php') ?>
  <?php include('../common/sidebar.php') ?>

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
              <form class="paypal" action="paypal-wallet-payments.php" method="get">
                <table class="table table-bordered">
                    <tr>
                      <td>Amount</td><th>$<?php echo $_GET['amount'] ?></th>
                    </tr>
                    <tr>
                      <td>Processing Fee</td><th>$<?php echo number_format($fee=$_GET['amount']*5.37/100,2);?></th>
                    </tr>
                    <tr>
                      <td>Total Budget</td><th>$<?php echo number_format($fee+$_GET['amount'],2); ?></th>
                    </tr>
                  </table>
                <div class="form-group">
                  <label>Amount</label>
                  <input type="number" class="form-control" name="amount" min="0" required readonly value="<?php echo number_format($_GET['amount']+$fee,2,'.','') ?>">
                </div>
                <div class="form-group text-center">
                  <?php require 'paypal/paypal-wallet-button.php' ?>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
</body>
</html>