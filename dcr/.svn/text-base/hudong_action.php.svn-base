<?php
require_once("../include/common.inc.php");
session_start();
require_once(WEB_CLASS . "/class.hudong.php");
require_once("adminyz.php");

$error_msg = array();//错误信息
$back = array('互动信息列表'=>'hudong_list.php');

$cls_hudong = new cls_hudong();
if($action == 'delorder')
{
	if($cls_hudong->delete($id))
	{
		$error_msg[] = '删除数据成功';
		show_msg($error_msg, 1, $back);
	}else
	{
		$error_msg[] = '删除数据失败';
		show_msg($error_msg, 1, $back);
	}
}else if($action == 'change_type_1')
{
	if($cls_hudong->update_type($id, 1))
	{
		$error_msg[] = '更新互动信息状态成功';
		show_msg($error_msg, 1, $back);
	}else
	{
		$error_msg[] = '更新互动信息失败';
		show_msg($error_msg, 1, $back);
	}
	
}else if($action == 'change_type_2')
{
	if($cls_hudong-> update_type($id, 2))
	{
		$error_msg[] = '更新互动信息状态成功';
		show_msg($error_msg, 1, $back);
	}else
	{
		$error_msg[] = '更新互动信息失败';
		show_msg($error_msg, 1, $back);
	}
}
?>