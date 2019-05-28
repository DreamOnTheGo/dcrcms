<?php
	include "../include/common.inc.php";
	session_start();
	include "class/class.member.admin.php";
	$m=new cls_member_admin('','');
	$isadmin=$m->logout();
	show_next('','login.htm');
?>