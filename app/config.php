<?php
session_start();
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(1);
define('DB_NAME', 'rma_app');
define('DB_USER', 'rma_app');
define('DB_PASSWORD', 'rma@v2016');
define('DB_HOST', 'localhost');

if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

define('baseurl', 'https://richmedia.biz/app/');
define('securitycode', 'rma');
require_once(ABSPATH . 'classes/settings.php');


define('PRO_PayPal', true);

if(PRO_PayPal){
	define("PayPal_CLIENT_ID", "AYI9YDMuitjuvx8ZV54-__EzYPinmaIPiMH6hdSXNjZmxQW7_2KbDsOqWvOYxl7Oy_qrIbGHQSjO7uDV");
	define("PayPal_SECRET", "EN6AFcTD99TZuhgmtybo3jc52h3INrU5uJWs7KC6NZyhi9sd_V_D2HWHHV_Ui22p2Gz8AtuUZoQzZnQA");
	define("PayPal_BASE_URL", "https://api.paypal.com/v1/");
}
else{

	define("PayPal_CLIENT_ID", "AePwXEVTyhzwrvDV94BJeUsxN-_wShhNXNnxsQlnyoA4gvnr_dunNlv7oWK2w9gLmteGJbkAKFi-s_b7");
	define("PayPal_SECRET", "EBq6UFYNVzUSd3erdepWAtMl6t6Hr5MDfAPaNJkDYXX9QrfhpJkp75iiWkVkcxVzrg4jk5mUrn222mSI");

	define("PayPal_BASE_URL", "https://api.sandbox.paypal.com/v1/");
}

define("Razorpar_API", "rzp_live_SgrUEZzaxAT1C8");

define('razorpar', true);
if(razorpar){
	define("keyId", "rzp_live_5v4ssMwHotnB6A");
	define("keySecret", "TtxKm2PRGUs1YBYk2h92i399");
	define("displayCurrency", "USD");
}else{
	define("keyId", "rzp_test_a2ZZQV5tDa9xxV");
	define("keySecret", "mh8TaFIpsuMEPph8KdXiGsiC");
	define("displayCurrency", "USD");
}

// difine('acountname',acountname());
// difine('acountno',acountno());
// difine('acountbranch',acountbranch());
// difine('acountifsc',acountifsc());
// difine('acountmicr',acountmicr());