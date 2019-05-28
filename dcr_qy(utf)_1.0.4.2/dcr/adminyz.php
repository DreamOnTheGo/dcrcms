<?php
$admin_u=$_SESSION['admin_u'];
$admin_p=$_SESSION['admin_p'];
include_once "class/member_admin_class.php";
$m=new Member_Admin($admin_u,$admin_p);
$isadmin=$m->yz();
if($isadmin){
}else{
	ShowNext('','login.htm',1);
	exit;
}
$_SESSION['web_dir']=$web_dir;
?>