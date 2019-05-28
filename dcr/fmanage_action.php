<?php
include "../include/common.inc.php";
session_start();
include "adminyz.php";
$pdir = WEB_DR.$cpath;
$pdir = pathinfo($pdir);
$pdir = $pdir['dirname'];
//echo $pdir;
//echo substr(WEB_DR,0,strlen(WEB_DR)-1);
if(WEB_DR == WEB_DR . $cpath || WEB_DR == $cpath ||  $pdir == substr(WEB_DR, 0, strlen(WEB_DR) - 1))
{
	$pdir = '';
}else{
	$pdir = str_replace(WEB_DR, '', $pdir);
}
$back = array('文件列表'=> 'fmanage.php?cpath=' . $pdir);
if($action == 'del_dir')
{
	if(empty($cpath))
	{
		show_msg('没有操作的目录',2);
	}
	
	if(!isset($cpath))
	{
		$cpath = WEB_DR;
	}else{
		$cpath = WEB_DR.$cpath;
	}
	require_once(WEB_CLASS . "/class.dir.php");
	$cls_dir = new cls_dir($cpath);
	$cls_dir-> delete_dir();
	show_msg('删除目录成功',1, $back);
	
}else if($action == 'rename')
{
	rename(WEB_DR . $dir_name . DIRECTORY_SEPARATOR . $oldname, WEB_DR . $dir_name . DIRECTORY_SEPARATOR . $newname);
	show_msg('重命名成功', 1, $back);
	
}else if($action == 'del_file')
{
	@unlink(WEB_DR . $cpath);
	show_msg('删除文件成功', 1, $back);
}else if($action=='edit_file')
{
	//编辑文件
	//格式化content
	//如果是sqlite 则要把''换成'
	if($db_type == 1){
		$content = str_replace("''", "'", $content);
	}
	$content = stripslashes($content);
	//var_dump($content);
	//exit;
	require_once(WEB_CLASS . '/class.file.php');
	$cls_file = new cls_file($filepath);
	$cls_file-> set_text($content);
	$r = $cls_file-> write(true);
	if($r == 'r1')
	{
		show_msg('修改文件失败:文件不存在', 2, $back);
	}else if($r == 'r2')
	{
		show_msg('修改文件失败:文件不可写', 2, $back);
	}else if($r == false)
	{
		show_msg('修改文件失败:原因未知', 2, $back);
	}else
	{
		show_msg('修改文件成功', 1, $back);
	}
}else
{
	show_msg('非法参数', 2, $back);
}
?>