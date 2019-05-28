<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");

require_once(WEB_CLASS . "/class.single.php");
$cls_single = new cls_single;

$error_msg = array();//错误信息
$back = array('公司资料'=>'single_list.php');

if($action == 'add')
{
	if(checkinput())
	{
		show_msg($error_msg, 2, $back);
	}else{
		//没有错误
		$single_info = array('title'=>$title,
						'content'=>$content
						);
		
		$aid = $cls_single->add($single_info);
		if(!$aid)
		{
			$error_msg[] = '添加单页面失败' . mysql_error();
			show_msg($error_msg, 2, $back);
		}else
		{
			$error_msg[] = '添加单页面成功';
			$back['继续添加'] = 'single_edit.php?action=add';
			show_msg($error_msg, 1, $back);
		}
	}
}else if($action == 'modify')
{
	if(checkinput())
	{
		show_msg($error_msg, 2, $back);
	}else
	{
		$single_info = array('title'=>$title,
						'content'=>$content
						);
		if($cls_single-> update($id, $single_info))
		{
			$error_msg[] = '更新单页面成功';
			show_msg($error_msg, 1, $back);
		}else
		{
			$error_msg[] = '更新单页面失败' . mysql_error();
			show_msg($error_msg, 2, $back);
		}
	}	
}else if($action == 'delsingle')
{
	if($cls_single->delete($id))
	{
		$error_msg[] = '删除数据成功';
		show_msg($error_msg, 1, $back);
	}else
	{
		$error_msg[] = '删除数据失败';
		show_msg($error_msg, 2, $back);
	}
}
function checkinput()
{
	global $error_msg, $title, $content;
	if(strlen($title) == 0)
	{
		$error_msg[] = '请填写资料标题';
		$iserror = true;
	}
	if(strlen($content) == 0)
	{
		$error_msg[] = '请填写资料内容';
		$iserror = true;
	}
	
	return $iserror;
}
?>