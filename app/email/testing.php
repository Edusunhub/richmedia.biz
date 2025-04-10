<?php
require_once('../config.php');

$to="skscatindia@gmail.com";
$message="Hello,<br/>New Advertiser registered on RMA Platform. The details as follow :<br/>
Full Name : Sathishkumar S<br/>
Email : skscatindia@gmail.com<br/>
Account Manager Name : Sathishkumar S<br/><br/>
From,<br/>
Rich Media Advertising<br/><br/>
This is the auto responder mail for the new user registration. Please do not reply.";
$cc="skscatindia@gmail.com";
echo sendmail($admindata['email'],'New Advertiser Registered',$message,$cc);