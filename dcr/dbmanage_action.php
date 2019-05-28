<?php
include "../include/common.inc.php";
session_start();
set_time_limit(0);
include "adminyz.php";
include WEB_CLASS."/class.db.bak.php";

//本页为操作新闻的页面
$db_bak=new cls_db_bak();
echo '<style>body{font-size:12px;}</style>';
if( $action=='bak_db' )
{
	if( count($table_list) == 0 ) exit('没有选择要备份的表！');
	$bak_data_path = WEB_MYSQL_BAKDATA_DIR;
	//清空备份目录
	//echo $bak_data_path;
	include WEB_CLASS . '/class.file.php';
	require_once(WEB_CLASS . '/class.dir.php');
	$table_struct_file_name = $bak_data_path . '/tables_struct_' . substr( md5(time() . mt_rand(1000,5000) . $tablepre), 0, 16) . '.txt';
	$cls_file = new cls_file($table_struct_file_name);
	echo '清空目录中....<br>';
	//show_msg('清空目录中',1,array(),'提示信息',false)
	$cls_dir = new cls_dir($bak_data_path);
	$cls_dir-> clear_dir();
	//先得出创建数据
	$db_bak->set_tables($table_list);
	$create_data = $db_bak-> get_create_table_sql();
	//$create_data=str_replace("\r","\r\n",$create_data);
	
	echo '备份数据中....<br>';
	$cls_file-> set_text($create_data);	
	$cls_file-> write();
	

	foreach($table_list as $table_name)
	{
		$db_bak->write_table_data_to_file($table_name);
	}
} elseif($action=='restore_db')
{
	//先找到tables_struct_*.txt
	//echo WEB_MYSQL_BAKDATA_DIR;
	chdir(WEB_MYSQL_BAKDATA_DIR);
	$tables_struct_file = glob("tables_struct_*.txt");
	$tables_struct_file = $tables_struct_file[0];//数据库结构
	
	$data_list_file=array();
	foreach($file_list as $filename){
		if($filename!=$tables_struct_file){
			$data_list_file[]=$filename;
		}
	}
	sort($data_list_file);
	$fp = fopen($tables_struct_file,'r');
	if($fp){
		while(!feof($fp)){
			$line = rtrim(fgets($fp,1024));
			if(ereg("\;$",$line)){
				$query .= $line;
				//echo $query.'<br>';
				$db->execute_none_query($query);
				//$rs = mysql_query($query,$conn);
				$query='';
			}else if(!ereg("^(//|--)",$line)){
				 $query .= $line;
			}
		}
	}else{
		echo '读取数据库结构表失败';
		exit;
	}
	fclose($fp);	
	
	$filename='';
	foreach($data_list_file as $filename){
		$fp = fopen($filename,'r');
		if($fp){
			while(!feof($fp)){
				$line = rtrim(fgets($fp,1024));
				if(ereg("\;$",$line)){
					$query .= $line;
					//echo $query.'<hr>';
					$db->execute_none_query($query);
					//$rs = mysql_query($query,$conn);
					$query='';
				}else if(!ereg("^(//|--)",$line)){
					 $query .= $line;
				}
			}
		}
		fclose($fp);	
	}
	
	//echo $tables_struct_file;
	//p_r($data_list_file);	
	show_msg('还原完成',1,array(),'提示信息',false);
}else{
	show_msg('非法参数',2,array(),'提示信息',false);
}
?>