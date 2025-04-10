<?php
if($_SESSION['logged'] && $_SESSION['type']==10){
}else{
	redirect(baseurl);
}
?>