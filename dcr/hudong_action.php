<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/hudong_class.php";
include "adminyz.php";

//提示信息开始
$errormsg=array();//错误信息
$back=array('互动信息列表'=>'hudong_list.php');
//提示信息结束

//本页为操作新闻的页面
$hudong=new HuDong(0);
if($action=='delorder'){
	if($hudong->Delete($id)){
		$errormsg[]='删除数据成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='删除数据失败';
		ShowMsg($errormsg,1,$back);
	}
}elseif($action=='change_type_1'){
	if($hudong->UpdateType($id,1)){
		$errormsg[]='更新互动信息状态成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='更新互动信息失败';
		ShowMsg($errormsg,1,$back);
	}
	
}elseif($action=='change_type_2'){
	if($hudong->UpdateType($id,2)){
		$errormsg[]='更新互动信息状态成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='更新互动信息失败';
		ShowMsg($errormsg,1,$back);
	}
}
?>