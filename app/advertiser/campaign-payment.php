<?php
require_once('../config.php');
require_once('session.php');
$price=$campaign->getCampaignByEncriptIO($_REQUEST['token']); //echo '<pre>'; print_r($price);
$user=$users->get_current_user();  

$price=$campaign->getCampaignByIdEncript($_REQUEST['token']);
if(isset($_REQUEST['token']) && $_REQUEST['later']==1 && $_REQUEST['data']=='later'){
  $payments->doLaterPayment($_REQUEST['token']);
}
if(isset($_POST['payment'])){
  $payments->walletPaymentMethod($_REQUEST['token']);
}
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
        <h4 class="white-layer-title">Payment</h4>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
              <div class="stepwizard-step col-xs-1.5">
                <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
                        <a type="button" class="btn btn-di btn-circle" disabled="disabled">1</a>
                <?php } else{ ?>
                        <a type="button" href="new-campaign.php?step=1&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">1</a>
                <?php } ?>            
                <p><small>Campaign Details</small></p>
              </div>
              <div class="stepwizard-step col-xs-1.5">
                <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
                        <a type="button" class="btn btn-di btn-circle" disabled="disabled">2</a>
                <?php } else{ ?>
                          <a type="button" href="new-campaign.php?step=2&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">2</a>
                <?php } ?>            
                <p><small>Targeting</small></p>
              </div>
              <div class="stepwizard-step col-xs-1.5">
                <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
                        <a type="button" class="btn btn-di btn-circle" disabled="disabled">3</a>
                <?php } else{ ?>
                          <a type="button" href="new-campaign.php?step=3&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">3</a>
                <?php } ?>            
                <p><small>Campaign Type</small></p>
              </div>
              <div class="stepwizard-step col-xs-1.5">
                <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
                        <a type="button" class="btn btn-di btn-circle" disabled="disabled">4</a>
                <?php } else{ ?>
                          <a type="button" href="new-campaign.php?step=5&type=<?php echo $_REQUEST['type'] ?>&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">4</a>
                <?php } ?>     
                <p><small>Creative Details</small></p>
              </div>
              <div class="stepwizard-step col-xs-1.5">
                <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
                        <a type="button" class="btn btn-di btn-circle" disabled="disabled">5</a>
                <?php } else{ ?>
                          <a type="button" href="new-campaign.php?step=6&type=<?php echo $_REQUEST['type'] ?>&model=<?php echo $_REQUEST['model'] ?>&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">5</a>
                <?php } ?>            
                <p><small>Pricing</small></p>
              </div>
              <div class="stepwizard-step col-xs-1.5">
                <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
                        <a type="button" href="new-campaign.php?step=7&type=<?php echo $_REQUEST['type'] ?>&typeid=<?php echo $_REQUEST['typeid'] ?>&model=<?php echo $_REQUEST['model'] ?>&token=<?php echo $_REQUEST['token'] ?>&renew=<?php echo $_REQUEST['renew'] ?>" class=" btn btn-default btn-circle">6</a>
                <?php } else{ ?>
                          <a type="button" href="new-campaign.php?step=7&type=<?php echo $_REQUEST['type'] ?>&typeid=<?php echo $_REQUEST['typeid'] ?>&model=<?php echo $_REQUEST['model'] ?>&token=<?php echo $_REQUEST['token'] ?>" class=" btn btn-default btn-circle">6</a>
                <?php } ?>
                <p><small>Scheduling</small></p>
              </div>
              <div class="stepwizard-step col-xs-1.5">
                <a type="button" class="active btn btn-default btn-circle">7</a>
                <p><small>Payment</small></p>
              </div>
            </div>
          </div>
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
                      <th><?php echo htmlspecialchars_decode($price['name']); ?></th>
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
                  <div class="box-header with-border">
                    <label class="cursor"><input type="radio" name="payment" value="1"> Wire Transfer</label>
                  </div>
                </div>
                <div class="wire-transfer-cover" style="display: none;">
                  <div class="col-sm-12">
                    <p class="mt-1 ">Please transfer the above mentioned amount to the following bank account</p>
                    <table class="table table-bordered ">
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
                  <div class="col-sm-12 text-center mb-2">
                    <a class="btn btn-default" href="wire-payment.php?token=<?php echo $_REQUEST['token'] ?>">Procced</a>
                  </div>
                </div>
                <div class="col-md-12 panel box mb-0">
                  <div class="box-header with-border">
                    <label class="cursor"><input type="radio" name="payment" value="2" checked> PayPal</label>
                  </div>
                </div>
                <div class="paypal-form">
                  <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                    <table class="table table-bordered">
                      <tr>
                        <td>Campaign Budget</td><th>$<?php echo $price['total_budget'] ?></th>
                      </tr>
                      <tr>
                        <td>Processing Fee</td><th>$<?php echo number_format($fee=$price['total_budget']*5.37/100,2);?></th>
                      </tr>
                      <tr>
                        <td>Total Budget</td><th>$<?php echo number_format($fee+$price['total_budget'],2); ?></th>
                      </tr>
                    </table>
                    <p class="text-center">Click the button to complete the payment via PayPal.</p>
                  </div>           
                <div class="col-sm-12 text-center mb-2">
                  <?php require 'paypal/paypalButton.php'; ?>                  
                </div>
              </div>
                <div class="col-md-12 panel box mb-0">
                  <div class="box-header with-border">
                    <label class="cursor"><input type="radio" name="payment" value="4"> Credit Card / Debit Card / upi</label>
                  </div>
                </div>
                <div class="razorpay-form" style="display: none;">
                  <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                    <table class="table table-bordered">
                      <tr>
                        <td>Campaign Budget</td><th>$<?php echo $price['total_budget'] ?></th>
                      </tr>
                      <tr>
                        <td>Processing Fee</td><th>$<?php echo number_format($fee=$price['total_budget']*2.8/100,2);?></th>
                      </tr>
                      <tr>
                        <td>Total Budget</td><th>$<?php echo number_format($fee+$price['total_budget'],2); ?></th>
                      </tr>
                    </table>
                  </div>
                  <div class="text-center">                     
                    <?php require 'razorpay/razorpayButton.php' ?> 
                  </div>
                  <br/>
                </div>
                <div class="col-md-12 panel box">
                  <div class="box-header with-border">
                    <label class="cursor"><input type="radio" name="payment" value="3"> Wallet</label>
                  </div>
                </div>
                <div class="wallet-form" style="display: none;">
                      <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                           <?php 
                              //if($user['wallet']>=$price['total_budget']){
                           if($payments->availableWalletAmount()>=$price['total_budget']){
                            ?>
                                <form method="post">                           
                                  <input type="checkbox" name="terms" id="terms" required>
                                  <label for="terms" class="cursor">I agree that I have made transfer to the above mentioned account</label>
                                  <div class="form-group text-center">
                                    <button type="submit" name="payment" class="btn btn-warning">Complete my Transaction</button>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-12 text-center">
                                      <small><a class="text-underline text-red" href="?token=<?php echo md5($price['id']) ?>&data=later&later=1">I will do it later</a></small>
                                    </div>
                                  </div>
                                </form>
                        <?php } else { ?>
                          <div class="col-md-12">
                            <div class="alert alert-danger">
                              <p class="text-center">You didn't have sufficient wallet balance to create this campaign</p>
                            </div>
                            <h3 class="text-center">Active Wallet Balance&nbsp;&nbsp;:&nbsp;&nbsp;$ <?php echo number_format($payments->availableWalletAmount(),2) ?></h3>
                          </div>
                        <?php } ?>
                      </div>
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
