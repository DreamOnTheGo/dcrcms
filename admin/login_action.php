<?php
session_start();
include "../include/common.inc.php";
if($_SESSION['admin_yz']!=$admin_yz){
	//ShowBack('您输入的验证码有误，请重新输入');
}
include "class/member_admin_class.php";
$password=encrypt($password);
$m=new Member_Admin($username,$password);
$isadmin=$m->yz();
if($isadmin){
	//如果是 登陆
	$m->login();
	ShowNext('','index.htm');
}else{
	ShowBack('您输入的用户名或密码，请重新输入');
}
?>