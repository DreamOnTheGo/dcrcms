<?php
$admin_u = $_SESSION['admin_u'];
$admin_p = $_SESSION['admin_p'];
include_once "class/class.member.admin.php";
$cls_member_admin = new cls_member_admin($admin_u,$admin_p);
$isadmin = $cls_member_admin->yz();
if( $isadmin )
{
}else
{
	show_next('','login.htm',1);
	exit;
}
$_SESSION['web_dir'] = $web_dir;
$web_url_module = 1;
?>