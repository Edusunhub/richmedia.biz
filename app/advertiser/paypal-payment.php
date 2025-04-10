<?php
require_once('../config.php');
require_once('session.php');
$price=$campaign->getCampaignByEncriptIO($_REQUEST['token']);
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
        <h4 class="white-layer-title"></h4>
        <?php echo flashNotification() ?>
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="white-box">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="white-box-titile text-center mb-2">Campaign Order Summary</h3>
                  <table class="table table-bordered text-center text-capitalize">
                    <head>
                      <tr>
                        <td>Campaign Name</td>
                        <td>Type</td>
                        <td>Model</td>
                        <td>Budget</td>
                      </tr>
                    </head>
                    <tr>
                      <th><?php echo $price['name'] ?></th>
                      <th><?php echo $price['type'] ?></th>
                      <th>
                        <?php
                        $model=$models->getModelByID($price['model']);
                        echo $model['name'];
                        ?>
                      </th>
                      <th>$<?php echo $price['total_budget'] ?></th>
                    </tr>
                  </table>
                </div>
              </div>
              <hr/>
              <h4 class="white-box-sub-titile text-center">Checkout</h4>
              <hr/>
              <div class="row">
                <div class="col-md-12 panel box mb-0">
                  <form class="paypal" action="payments.php" method="post" id="paypal_form">
                    <input type="hidden" name="cmd" value="_xclick" />
                    <input type="hidden" name="no_note" value="1" />
                    <input type="hidden" name="lc" value="UK" />
                    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                    <input type="hidden" name="first_name" value="Customer's First Name" />
                    <input type="hidden" name="last_name" value="Customer's Last Name" />
                    <input type="hidden" name="payer_email" value="customer@example.com" />
                    <input type="hidden" name="item_number" value="123456" / >
                    <input type="submit" name="submit" value="Submit Payment"/>
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
  <?php //include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
</body>
</html>
