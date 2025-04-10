<?php
if($_SESSION['logged'] && $_SESSION['type']==5){
}else{
	redirect(baseurl);
}
?>