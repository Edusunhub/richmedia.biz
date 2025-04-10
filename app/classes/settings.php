<?php
include('autoload.php');

function redirect($url){
	header("location:".$url);
	exit();
}

function flashNotification(){
	$flash='';
	if(isset($_SESSION['flash'])){
		$flash .='
		<div class="row">
		<div class="alert alert-'.$_SESSION['flash_class'].' alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		'.$_SESSION['flash_msg'].'
		</div>
		</div>';
		unset($_SESSION['flash']);
		unset($_SESSION['flash_class']);
		unset($_SESSION['flash_msg']);
	}
	return $flash;
}

function activeMenu($pages){
	$cpage=basename($_SERVER['PHP_SELF']);
	if(in_array($cpage,$pages)){
		return 'active';
	}
}

function show($arg=''){
	if($arg==404){
		include('../'.$arg.'.php');
	}
}

function selectOption($stack,$value){
	if($stack==$value){
		return 'selected';
	}
	return '';
}

function selectInOption($stack,$arrayValue){
	if(!empty($arrayValue)){
		if(in_array($stack,$arrayValue)){
			return 'selected';
		}
	}
	return '';
}

function selectIndisable($stack,$arrayValue){
	if(!empty($arrayValue)){
		if(in_array($stack,$arrayValue)){
			return 'disabled';
		}
	}
	return '';
}

function stylenone($stack,$arrayValue){
	if(!empty($arrayValue)){
		if(in_array($stack,$arrayValue)){
			return 'style="display: none;"';
		}
	}
	return '';
}

function filterSelect($stack,$value){
	if($stack==$value){
		return 'selected';
	}
}

function checkedOption($stack,$value){
	if($stack==$value){
		return 'checked';
	}
	return 'disabled';
}

function cursorpointer($stack,$value){
	if($stack==$value){
		return '';
	}
	return 'style="cursor: not-allowed !important;"';
}


/*function sendMail($to,$subject,$message){
	// To send HTML mail, the Content-type header must be set
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';
	// Additional headers
	$headers[] = 'From:Herbo Trends <info@herbotrends.com>';
	// Mail it
	return mail($to, $subject, $message, implode("\r\n", $headers));
}*/

function sendMail($to,$subject,$message,$cc=''){
	$headers = "From: Richmedia <info@richmedia.biz>\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	if($cc){
		$headers .= "CC: ".$cc."\r\n";
	}
	// Mail it
	return $mail=mail($to, $subject, $message, $headers);
}

function getTruncatedValue( $value, $precision ) {
    //Casts provided value
    $value = ( string )$value;

    //Gets pattern matches
    preg_match( "/(-+)?\d+(\.\d{1,".$precision."})?/" , $value, $matches );

    //Returns the full pattern match
    return $matches[0];            
};

function acountname(){
	return $common->getSetting('account_name');
}
function acountno(){
	return $common->getSetting('account_number');
}
function acountbranch(){
	return $common->getSetting('branch_name');
}
function acountifsc(){
	return $common->getSetting('ifsc_code');
}
function acountmicr(){
	return $common->getSetting('micr_code');
}