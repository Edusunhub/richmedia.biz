<?php
if($_SESSION['logged'] && $_SESSION['type']==2){
}else{
	redirect(baseurl);
}
?>