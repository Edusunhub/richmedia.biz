<?php
require_once('../config.php');
require_once('session.php');
$price=$campaign->getCampaignByEncriptIO(md5($_REQUEST['key']));
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Create Campaign</title>
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
      'name'=>'Create Campaign'
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
        <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> - Campaign Details</h4>
        <?php echo flashNotification() ?>
        
        <div class="white-box">
          <div class="row">
            <div class="col-sm-12">
              <h4 class="white-box-sub-titile">Payment:</h4>
            </div>
            <div class="col-md-6">
              <div class="row">
                  <form action="<?php echo PAYPAL_URL; ?>" method="post">
                    <div class="form-group text-center pt-10 pb-10">
                      <!-- Identify your business so that you can collect the payments. -->
                      <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
                      <!-- Specify a Buy Now button. -->
                      <input type="hidden" name="cmd" value="_xclick">
                      <!-- Specify details about the item that buyers will purchase. -->
                      <input type="hidden" name="item_name" value="<?php echo $_REQUEST['token']; ?>">
                      <input type="hidden" name="item_number" value="<?php echo $_REQUEST['token']; ?>">
                      <input type="hidden" name="amount" value="<?php echo $price['total_budget']; ?>">
                      <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">
                      <!-- Specify URLs -->
                      <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
                      <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
                      <!-- Display the payment button. -->
                      <input type="image" name="submit" class="payment-image-set" border="0" src="<?php echo baseurl.'/images/paypal.png' ?>">
                      <input type="hidden" name="token" value="<?php echo $_REQUEST['token'] ?>">
                    </div>
                  </form>
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
<?php include('../common/footer-script.php') ?>
</body>
</html>
