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
                <div class="row">
                  <div class="col-md-12">
                    <h3 class="white-box-titile text-center mb-2">Wallet Recharge</h3>
                  </div>
                  <div class="col-md-12 panel box mb-0">
                    <div class="box-header with-border">
                      <label class="cursor"><input type="radio" class="wallet-payment" name="payment" value="1" checked /> Wire Transfer</label>
                    </div>
                  </div>
                  <div class="col-md-12 wire-transfer-cover" id="wallet-form" style="display: none;">
                    <form method="post">
                      <div class="row">
                        <div class="col-sm-12">
                          <p class="mt-1">Please fill your Transaction ID and remarks to complete the transaction.</p>
                            <div class="form-group">
                              <label>Amount</label>
                              <input type="number" class="form-control" name="amount" min="0" required step="any">
                            </div>
                            <div class="form-group">
                              <label>Transaction ID</label>
                              <input type="text" class="form-control" name="transactionid" required>
                            </div>
                            <div class="form-group">
                              <label>Remarks</label>
                              <textarea class="form-control" rows="4" name="remarks"></textarea>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="wire-transfer-cover">
                          <div class="col-sm-12">
                            <h3 class="white-box-titile text-center mb-2">Account details</h3>
                            <table class="table ">
                              <tr>
                                <td>Account Name</td>
                                <td>:</td>
                                <th><?php echo $common->getSetting('account_name') ?></th>
                              </tr>
                              <tr>
                                <td>Account Number</td>
                                <td>:</td>
                                <th><?php echo $common->getSetting('account_number') ?></th>
                              </tr>
                              <tr>
                                <td>Branch Name</td>
                                <td>:</td>
                                <th><?php echo $common->getSetting('branch_name') ?></th>
                              </tr>
                              <tr>
                                <td>IFSC Code</td>
                                <td>:</td>
                                <th><?php echo $common->getSetting('ifsc_code') ?></th>
                              </tr>
                              <tr>
                                <td>MICR Code</td>
                                <td>:</td>
                                <th><?php echo $common->getSetting('micr_code') ?></th>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                      <input type="checkbox" name="terms" id="terms" required>
                      <label for="terms" class="cursor">I agree that I have made transfer to the above mentioned account</label>
                      <div class="form-group text-center">
                        <button type="submit" name="walletpayment" class="btn btn-warning">Complete my Transaction</button>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-12 panel box mb-0">
                    <div class="box-header with-border">
                      <label class="cursor"><input type="radio" class="wallet-payment" name="payment" value="2" checked /> Paypal</label>
                    </div>
                  </div>
                  <div class="col-md-12 paypal-form" id="paypal-form">
                    <form class="paypal" action="paypal-wallet-payments.php" method="get">
                      <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" name="amount" min="0" required step="any">
                      </div>
                      <div class="form-group text-center">
                        <button type="submit" name="walletpayment" class="btn btn-warning">Next</button>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-12 panel box mb-0">
                    <div class="box-header with-border">
                      <label class="cursor"><input type="radio" class="razorpay-payment" name="payment" value="4" />Credit Card / Debit Card / UPI</label>
                    </div>
                  </div>
                  <div class="col-md-12 razorpay-form" id="razorpay-form" style="display: none;">
                    <form class="paypal" action="razorpay-wallet-payments.php" method="get">
                      <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" name="amount" min="0" required step="any">
                      </div>
                      <div class="form-group text-center">
                        <button type="submit" name="walletpayment" class="btn btn-warning">Next</button>
                      </div>
                    </form>
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
  <?php include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
</body>
</html>