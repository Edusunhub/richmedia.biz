<?php
$amt=$_GET['amount']*5.37/100;
$total=number_format($amt+$_GET['amount'],2);
?>
<div id="paypal-button-container"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    paypal.Button.render({
        <?php if(PRO_PayPal) { ?>
        env: 'production', 
        <?php } else {?> 
        env: 'sandbox',
        <?php } ?>

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create
        client: {
            sandbox:    '<?php echo PayPal_CLIENT_ID; ?>',
            production: '<?php echo PayPal_CLIENT_ID; ?>'
        },

        // Show the buyer a 'Pay Now' button in the checkout flow
        commit: true,

        // payment() is called when the button is clicked
        payment: function(data, actions) {
            
            // Make a call to the REST api to create the payment
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '<?php echo $total ?>', currency: 'USD' },
                            item_list: {
                                items: [
                                    {
                                        name: "Wallet Recharge",
                                        description: "Wallet Recharge",
                                        quantity: "1",
                                        price: "<?php echo $total ?>",
                                        currency: "USD"
                                    }
                                ]
                            }
                        }
                    ]
                }
            });
        },

        // onAuthorize() is called when the buyer approves the payment
        onAuthorize: function(data, actions) {
            // Make a call to the REST api to execute the payment
            return actions.payment.execute().then(function() {

                window.location = "<?php echo baseurl ?>/advertiser/paypal/process.php?paymentID="+data.paymentID+"&payerID="+data.payerID+"&token="+data.paymentToken+"&userid=<?php echo $_SESSION['userid']  ?>&type=wallet&amount=<?php echo $_GET['amount'] ?>";

            });
        }


    }, '#paypal-button-container');

</script>