<?php
if($_SESSION['logged'] && $_SESSION['type']==3){
}else{
	redirect(baseurl);
}
?>