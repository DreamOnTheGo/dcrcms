<?php
	include "../include/common.inc.php";
	session_start();
	if($_SESSION['admin_yz']!=$admin_yz){
		show_back('您输入的验证码有误，请重新输入');
	}
	include "class/class.member.admin.php";
	$password=encrypt($password);
	$m=new cls_member_admin($username,$password);
	$isadmin=$m->yz();
	if($isadmin){
		//如果是 登陆
		$m->login();
		show_next('','index.htm');
	}else{
		show_back('您输入的用户名或密码，请重新输入');
	}
?>