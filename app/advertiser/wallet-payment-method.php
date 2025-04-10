<?php
require_once('../config.php');
require_once('session.php');
$user=$users->get_current_user();  

$price=$campaign->getCampaignByIdEncript($_REQUEST['token']);
if(isset($_REQUEST['token']) && $_REQUEST['later']==1 && $_REQUEST['data']=='later'){
  $payments->doLaterPayment($_REQUEST['token']);
}
if(isset($_POST['payment'])){
  $payments->wirePayment($_REQUEST['token']);
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
        <h4 class="white-layer-title"></h4>
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="white-box">
              <div class="col-md-12">
                <?php echo flashNotification() ?>
              </div>
              <form method="post">
                <div class="row">
                  <div class="wire-transfer-cover">
                    <div class="col-sm-12">
                      <h3 class="white-box-titile text-center mb-2">Campaign Order Summary</h3>
                      <table>
                        <tr>
                        <th><h2 style="padding-bottom: 0px;">Wallet Amount</h2></th>
                      </tr>
                      <tr>
                        <td>
                          <?php echo '<h3>$'.$user['wallet'].'</h3>'; ?>
                        </td>
                      </tr>
                      </table>
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
                        <th><?php echo $price['name']; echo $user['wallet']; ?></th>
                        <th><?php echo $price['type'] ?></th>
                        <th>
                          <?php
                          $model=$models->getModelByID($price['model']);
                          echo $model['name'];
                          ?>
                        </th>
                        <th>$<?php echo number_format($price['total_budget'],2); ?></th>
                      </tr>
                    </table>
                    </div>
                  </div>
                </div>
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
<script>
(function (global) { 

    if(typeof (global) === "undefined") {
        throw new Error("window is undefined");
    }

    var _hash = "!";
    var noBackPlease = function () {
        global.location.href += "#";

        // making sure we have the fruit available for juice (^__^)
        global.setTimeout(function () {
            global.location.href += "!";
        }, 50);
    };

    global.onhashchange = function () {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };

    global.onload = function () {            
        noBackPlease();

        // disables backspace on page except on input fields and textarea..
        document.body.onkeydown = function (e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                e.preventDefault();
            }
            // stopping event bubbling up the DOM tree..
            e.stopPropagation();
        };          
    }

})(window);
</script>
</body>
</html>
