<?php
require_once('config.php');
global $db;

if(isset($_GET['action']) && $_GET['action']=='getstate'){
	$states=$common->getstate($_GET['value']);
	$html ='<option value="" disabled selected>Select State</option>';
	if(!empty($states)){
		foreach ($states as $key => $state) {
			$html .='<option value="'.$state['id'].'">'.$state['name'].'</option>';
		}
	}
	echo $html;
}

if(isset($_GET['action']) && $_GET['action']=='getcity'){
	$cities=$common->getcity($_GET['value']);
	$html ='<option value="" disabled selected>Select City</option>';
	if(!empty($cities)){
		foreach ($cities as $key => $city) {
			$html .='<option value="'.$city['id'].'">'.$city['name'].'</option>';
		}

	}
	echo $html;
}
if(isset($_GET['action']) && $_GET['action']=='checkemail'){
	$mail=$users->emailExist($_GET['mail']);
	if($mail){
		echo "true";
	}else{
		echo "false";
	}
}
if(isset($_GET['action']) && $_GET['action']=='check_members_email'){
	$mail=$members->emailExist($_GET['mail']);
	if($mail){
		echo "true";
	}else{
		echo "false";
	}
}
if(isset($_POST['action']) && $_POST['action']=='import'){
	echo $reportModule->import();
}