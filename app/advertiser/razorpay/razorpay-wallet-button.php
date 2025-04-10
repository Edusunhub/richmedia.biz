<?php
$amt=$_GET['amount']*2.8/100;
$total=$amt+$_GET['amount'];
?>
<button id="rzp-button1">Pay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "<?php echo Razorpar_API; ?>", // Enter the Key ID generated from the Dashboard
    "amount": "<?php echo str_replace('.','',number_format($total, 2,'','')) ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
    "currency": "USD",
    "name": "<?php echo $user['name'] ?>",
    "description": "Wallet Recharge",
    "image": "https://example.com/your_logo",

    "handler": function (response){
        JSON.stringify(response);
        //console.log(response.razorpay_payment_id);
        window.location = "<?php echo baseurl ?>/advertiser/razorpay/process.php?paymentID="+response.razorpay_payment_id+"&id=<?php echo $_SESSION['userid']  ?>&type=Wallet Recharge&amount=<?php echo $_GET['amount'] ?>";
    },
    "prefill": {
        "name": "<?php echo $user['name'] ?>",
        "email": "<?php echo $user['email'] ?>",
        "contact": "<?php echo $user['phone'] ?>"
    },
    "notes": {
        "address": "note value"
    },
    "theme": {
        "color": "#F37254"
    }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>