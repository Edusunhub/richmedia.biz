<?php
require_once('../config.php');
require_once('session.php');
$user=$users->getUser($_SESSION['userid']);
require(ABSPATH.'payment-gateways/razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$keyId=keyId;
$keySecret=keySecret;
$displayCurrency=displayCurrency;

$api = new Api($keyId, $keySecret);

$amt=$_GET['amount']*100;
$tax=$amt*2.8/100;
$total=$amt+$tax;

$orderData = [
    'amount'          => $total, // 2000 rupees in paise
    'currency'        => 'USD',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];


/*if ($displayCurrency !== 'INR')
{
    echo $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    echo $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}*/


$checkout = 'automatic';

/*if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
}*/

$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => $user['name'],
    "description"       => "Wallet Recharge",
    "image"             => "https://www.richmedia.biz/assets/images/logo.png",
    "prefill"           => [
        "name"              => $user['name'],
        "email"             => $user['email'],
        "contact"           => $user['phone'],
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];


$json = json_encode($data);

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
              <form action="<?php echo baseurl ?>/advertiser/razorpay/verify.php" method="POST" class="razorpay-payment-form">
                <table class="table table-bordered">
                  <tr>
                    <td>Campaign Budget</td>
                    <th>$<?php echo $_GET['amount'] ?></th>
                  </tr>
                  <tr>
                    <td>Processing Fee</td>
                    <th>$<?php echo number_format($fee=$_GET['amount']*2.8/100,2);?></th>
                  </tr>
                  <tr>
                    <td>Total Budget</td>
                    <th>$<?php echo number_format($fee+$_GET['amount'],2); ?></th>
                  </tr>
                </table>
                <div class="form-group">
                  <label>Amount</label>
                  <input type="number" class="form-control" step="any" min="0" required readonly value="<?php echo number_format($fee+$_GET['amount'],2,'.','') ?>">
                </div>
                
                <script
                src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="<?php echo $data['key']?>"
                data-amount="<?php echo $data['amount']?>"
                data-currency="INR"
                data-name="<?php echo $data['name']?>"
                data-image="<?php echo $data['image']?>"
                data-description="<?php echo $data['description']?>"
                data-prefill.name="<?php echo $data['prefill']['name']?>"
                data-prefill.email="<?php echo $data['prefill']['email']?>"
                data-prefill.contact="<?php echo $data['prefill']['contact']?>"
                data-order_id="<?php echo $data['order_id']?>"                
                >
                </script>
                
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['userid'] ?>">
                <input type="hidden" name="type" value="1">
                <input type="hidden" name="amount" min="0" value="<?php echo $_GET['amount'] ?>">
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
<style type="text/css">
.razorpay-payment-button {
    border: 0;
    border-radius: 3px;
    -webkit-transition: .2s;
    transition: .2s;
    box-shadow: 0 3px 13px rgba(0,0,0,0.09), 0 1px 5px 0 rgba(0,0,0,0.14);
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
    line-height: 40px;
    padding: 0 24px;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: .5px;
    font-weight: bold;
    background: #528ff0;
    color: #fff;
    cursor: pointer;
    display: inherit;
    margin: 0 auto;
}
.razorpay-payment-button:active {
    -webkit-transform: perspective(40px) rotateX(1deg);
    transform: perspective(40px) rotateX(1deg);
}
.razorpay-payment-button:hover {
    -webkit-transform: translateY(-2px) scale(1.01);
    -ms-transform: translateY(-2px) scale(1.01);
    transform: translateY(-2px) scale(1.01);
    box-shadow: 0 5px 16px 1px rgba(0,0,0,0.13), 0 1px 4px 0 rgba(0,0,0,0.09);
}
</style>
</body>
</html>