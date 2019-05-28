<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");

$error_msg = array();//错误信息
$back = array('新闻列表'=>'news_list.php');

//本页为操作新闻的页面
if($action == 'changpas')
{
	$error_msg = '';
	$iserror = false;
	$m_cp = new cls_member_admin($admin_u,jiami($oldpassword));
	if(!$m_cp->yz())
	{
		$error_msg[] = '原密码错误';
		$iserror = true;
	}
	if(strlen($newpassword1)<4 || strlen($newpassword1)>16)
	{
		$error_msg[] = '新密码长度应该在4-16之间';
		$iserror = true;
	}
	if($newpassword1 != $newpassword2)
	{
		$error_msg[] = '新密码前后输入不一致';
		$iserror = true;
	}
	if($iserror)
	{
		show_msg($error_msg, 2);
	}else
	{
		if(!$m_cp->changpas($newpassword1))
		{
			$error_msg[] = '修改密码失败';
			show_msg($error_msg, 2);		
		}else
		{
			$m_cp->logout();
			$error_msg[] = '修改密码成功,请重新登陆';
			show_msg($error_msg, 1);
		}
	}
}
?>