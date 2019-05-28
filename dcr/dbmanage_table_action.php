<?php
set_time_limit(0);
include "../include/common.inc.php";
session_start();
include "adminyz.php";

//本页为操作新闻的页面
if('opimize' == $action)
{
	if( empty($table_name) )
	{
		echo '请选择要优化的表';
		exit;
	}
	$sql="optimize table `$table_name` ";
	$db->execute_none_query($sql);
	echo "优化" . $table_name . "完成！";
}elseif('opimize_all' == $action)
{
	include_once WEB_CLASS . "/class.db.bak.php";
	$db_bak = new cls_db_bak($db);
	$table_list=$db_bak->get_table_list();
	sort($table_list);
	$table_num=count($table_list);
	for($i = 0;$i < $table_num;$i++){		
		$sql="optimize table `". $table_list[$i] ."` ";
		$db->execute_none_query($sql);
		echo "优化". $table_list[$i] ."完成！<br>";
	}	
}elseif('view_info' == $action)
{
	if( empty($table_name) )
	{
		echo '请选择要查看的表';
		exit;
	}
	$sql = 'show create table '.$table_name;
	$table_create_arr = $db->Execute($sql,MYSQL_NUM);
	p_r($table_create_arr[0][1]);
}elseif('repair' == $action)
{
	if( empty($table_name) )
	{
		echo '请选择要修复的表';
		exit;
	}
	$sql="repair table `$table_name` ";
	$db->execute_none_query($sql);
	echo "修复" . $table_name . "完成！";
}elseif('repair_all' == $action)
{
	include_once WEB_CLASS . "/class.db.bak.php";
	$db_bak=new cls_db_bak($db);
	$table_list=$db_bak->get_table_list();
	sort($table_list);
	$table_num=count($table_list);
	for($i = 0;$i < $table_num;$i++){		
		$sql="repair table `". $table_list[$i] ."` ";
		$db->execute_none_query($sql);
		echo "修复". $table_list[$i] ."完成！<br>";
	}	
}else{
	show_msg('非法参数',2,array(),'提示信息',false);
}
?>