<?php
session_start();
set_time_limit(0);
include "../include/common.inc.php";
include "adminyz.php";
include WEB_CLASS."/db_bak_class.php";

//本页为操作新闻的页面
$db_bak=new DB_BAK();
echo '<style>body{font-size:12px;}</style>';
if($action=='bak_db'){
	if(count($table_list)==0)exit('没有选择要备份的表！');
	$bak_data_path=WEB_MYSQL_BAKDATA_DIR;
	//清空备份目录
	//echo $bak_data_path;
	include WEB_CLASS.'f_class.php';
	$f=new FClass($bak_data_path);
	echo '清空目录中....<br>';
	//ShowMsg('清空目录中',1,array(),'提示信息',false);
	$f->ClearDir();
	//先得出创建数据
	$db_bak->SetTables($table_list);
	$create_data=$db_bak->GetCreateTableSql();
	//$create_data=str_replace("\r","\r\n",$create_data);
	
	echo '备份数据中....<br>';
	$f->setText($create_data);	
	$f->saveToFile($bak_data_path.'tables_struct_'.substr(md5(time().mt_rand(1000,5000).$tablepre),0,16).'.txt');
	
	//备份数据
	foreach($table_list as $table_name){
		$result_arr=array();
		$db_bak->Get_Table_Data($table_name,$result_arr);
		foreach($result_arr as $key=>$value){
			$f->setText($value);
			$f->saveToFile($bak_data_path.$table_name.'_'.$key.'_'.substr(md5(time().mt_rand(1000,5000).$tablepre),0,16).'.txt');	
			echo "$table_name(分卷$key)备份成功<br>";
		}
	}
	echo '<span style=color:green>备份完成！</span>';
}elseif($action=='restore_db'){
	//先找到tables_struct_*.txt
	//echo WEB_MYSQL_BAKDATA_DIR;
	chdir(WEB_MYSQL_BAKDATA_DIR);
	$tables_struct_file=glob("tables_struct_*.txt");
	$tables_struct_file=$tables_struct_file[0];//数据库结构
	
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
				$db->ExecuteNoneQuery($query);
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
					$db->ExecuteNoneQuery($query);
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
	ShowMsg('还原完成',1,array(),'提示信息',false);
}else{
	ShowMsg('非法参数',2,array(),'提示信息',false);
}
?>