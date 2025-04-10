<?php
if($_SESSION['logged'] && $_SESSION['type']==10){
  include('admin.php');
}elseif($_SESSION['logged'] && $_SESSION['type']==2){
	include('mandate.php');
}
elseif($_SESSION['logged'] && $_SESSION['type']==5){
	include('support.php');
}elseif($_SESSION['logged'] && $_SESSION['type']==3){
  include('manager.php');
}else{
	include('advertiser.php');
}
?>