<?php
$user=$users->getUser($_SESSION['userid']);
require(ABSPATH.'payment-gateways/razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$keyId=keyId;
$keySecret=keySecret;
$displayCurrency=displayCurrency;

$api = new Api($keyId, $keySecret);

$amt=$price['total_budget']*100;
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
    "description"       => "Campaign payment ".$price['id'],
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
<form action="<?php echo baseurl ?>/advertiser/razorpay/verify.php" method="POST" class="razorpay-payment-form">
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

    <input type="hidden" name="id" value="<?php echo $price['id']  ?>">
    <input type="hidden" name="type" value="2">
    <input type="hidden" name="amount" min="0" value="<?php echo $price['total_budget'] ?>">
</form>
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