<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/product_class.php";
include "adminyz.php";

//提示信息开始
$errormsg=array();//错误信息
$back=array('新闻列表'=>'news_list.php');
//提示信息结束

//本页为操作新闻的页面
if($action=='changpas'){
	$errormsg='';
	$iserror=false;
	$m_cp=new Member_Admin($admin_u,jiami($oldpassword));
	if(!$m_cp->yz()){
		$errormsg[]='原密码错误';
		$iserror=true;
	}
	if(strlen($newpassword1)<4 || strlen($newpassword1)>16){
		$errormsg[]='新密码长度应该在4-16之间';
		$iserror=true;
	}
	if($newpassword1!=$newpassword2){
		$errormsg[]='新密码前后输入不一致';
		$iserror=true;
	}
	if($iserror){
		ShowMsg($errormsg,2);
	}else{
		if(!$m_cp->changpas($newpassword1)){
			$errormsg[]='修改密码失败';
			ShowMsg($errormsg,2);		
		}else{
			$m_cp->logout();
			$errormsg[]='修改密码成功,请重新登陆';
			ShowMsg($errormsg,1);
		}
	}
}
?>