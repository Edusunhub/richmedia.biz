<?php
require_once('../../config.php');
require_once('../session.php');
$price=$campaign->getCampaignByEncriptIO($_POST['token']);

$enableSandbox = true;

// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
$paypalConfig = [
	'email' => PAYPAL_ID,
	'return_url' => baseurl.'/advertiser/payment-successful.php',
	'cancel_url' => baseurl.'/advertiser/payment-cancelled.php',
	'notify_url' => baseurl.'/advertiser/paypal/payments.php'
];
$paypalUrl = PAYPAL_SANDBOX ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

// Product being purchased.
$itemName = $price['name'];
$total_budget = $price['total_budget'];
$itemAmount = number_format((float)$total_budget, 2, '.', '');

// Include Functions
require 'functions.php';

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {

	// Grab the post data so that we can set up the query string for PayPal.
	// Ideally we'd use a whitelist here to check nothing is being injected into
	// our post data.
	$data = [];
	foreach ($_POST as $key => $value) {
		$data[$key] = stripslashes($value);
	}

	// Set the PayPal account.
	$data['business'] = $paypalConfig['email'];

	// Set the PayPal return addresses.
	$data['return'] = stripslashes($paypalConfig['return_url']);
	$data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
	$data['notify_url'] = stripslashes($paypalConfig['notify_url']);

	// Set the details about the product being purchased, including the amount
	// and currency so that these aren't overridden by the form data.
	$data['amount'] = $itemAmount;
	$data['currency_code'] = 'INR';

	// Add any custom fields for the query string.
	//$data['custom'] = USERID;

	// Build the query string from the data.
	$queryString = http_build_query($data);

	// Redirect to paypal IPN
	header('location:' . $paypalUrl . '?' . $queryString);
	exit();

} else {

	// Handle the PayPal response.

	// Create a connection to the database.
	//$db = new mysqli(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);

	// Assign posted variables to local data array.
	$data = [
		'item_name' => $_POST['item_name'],
		'item_number' => $_POST['item_number'],
		'payment_status' => $_POST['payment_status'],
		'payment_amount' => $_POST['mc_gross'],
		'payment_currency' => $_POST['mc_currency'],
		'txn_id' => $_POST['txn_id'],
		'receiver_email' => $_POST['receiver_email'],
		'payer_email' => $_POST['payer_email'],
		'user_id' => $_POST['user_id'],
		'type' => $_POST['type'],
	];

	// We need to verify the transaction comes from PayPal and check we've not
	// already processed the transaction before adding the payment to our
	// database.
	/*if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {
		if (addPayment($data) !== false) {
			// Payment successfully added.
		}
	}*/
}