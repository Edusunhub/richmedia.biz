<?php
if($_SESSION['logged'] && $_SESSION['type']==1){
}else{
	redirect(baseurl);
}
?>