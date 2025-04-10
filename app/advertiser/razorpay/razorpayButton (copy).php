<button class="btn btn-warning pb-3 mb-2 mt-2" id="rzp-button1">Proceed Payment</button>
<?php $amt=$price['total_budget']*2.8/100;
$total_budget=$amt+$price['total_budget']; ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "<?php echo Razorpar_API; ?>", // Enter the Key ID generated from the Dashboard
    "amount": "<?php echo str_replace('.','',number_format($total_budget, 2,'','')) ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
    "currency": "USD",
    "name": "<?php echo $user['name'] ?>",
    "description": "Campaign payment <?php echo $price['id']; ?>",
    "image": "https://example.com/your_logo",

    "handler": function (response){
        alert(JSON.stringify(response));
        //console.log(response.razorpay_payment_id);
        window.location = "<?php echo baseurl ?>/advertiser/razorpay/process.php?paymentID="+response.razorpay_payment_id+"&id=<?php echo $price['id']  ?>&type=campaign&amount=<?php echo $price['total_budget'] ?>";
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