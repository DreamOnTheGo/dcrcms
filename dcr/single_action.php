<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/single_class.php";
$single=new Single;
//提示信息开始
$errormsg=array();//错误信息
$back=array('公司资料'=>'single_list.php');
//提示信息结束

//本页为操作新闻的页面
if($action=='add'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);
	}else{
		//没有错误
		$singleInfo=array('title'=>$title,
						'content'=>$content
						);
		
		$aid=$single->Add($singleInfo);
		if(!$aid){
			$errormsg[]='添加单页面失败'.mysql_error();
			ShowMsg($errormsg,2,$back);	
		}else{
			$errormsg[]='添加单页面成功';
			$back['继续添加']='single_edit.php?action=add';
			ShowMsg($errormsg,1,$back);
		}
	}
}elseif($action=='modify'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);
	}else{
		$singleInfo=array('title'=>$title,
						'content'=>$content
						);
		if($single->Update($id,$singleInfo)){
			$errormsg[]='更新单页面成功';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='更新单页面失败'.mysql_error();
			ShowMsg($errormsg,2,$back);
		}
	}	
}elseif($action=='delsingle'){
	if($single->Delete($id)){
		$errormsg[]='删除数据成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='删除数据失败';
		ShowMsg($errormsg,2,$back);
	}
}
function checkinput(){
	global $errormsg,$title,$content;
	if(strlen($title)==0){
		$errormsg[]='请填写资料标题';
		$iserror=true;
	}
	if(strlen($content)==0){
		$errormsg[]='请填写资料内容';
		$iserror=true;
	}
	return $iserror;
}
?>