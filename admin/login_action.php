<?php
session_start();
include "../include/common.inc.php";
if($_SESSION['admin_yz']!=$admin_yz){
	//ShowBack('���������֤����������������');
}
include "class/member_admin_class.php";
$password=encrypt($password);
$m=new Member_Admin($username,$password);
$isadmin=$m->yz();
if($isadmin){
	//����� ��½
	$m->login();
	ShowNext('','index.htm');
}else{
	ShowBack('��������û��������룬����������');
}
?>