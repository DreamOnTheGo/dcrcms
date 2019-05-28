<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/news_class.php";
$news=new News;
//提示信息开始
$errormsg=array();//错误信息
$back=array('新闻列表'=>'news_list.php');
//提示信息结束

//本页为操作新闻的页面
if($action=='add'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);
	}else{
		//没有错误
			$newsInfo=array('title'=>$title,
							'classid'=>$classid,
							'author'=>$author,
							'source'=>$source,
							'keywords'=>$keywords,
							'description'=>$description,
							'content'=>$content
							);
		$aid=$news->Add($newsInfo);
		if(!$aid){
			$errormsg[]='插入新闻失败'.mysql_error();
			ShowMsg($errormsg,2,$back);	
		}else{
			$errormsg[]='插入新闻成功';
			ShowMsg($errormsg,1,$back);
		}
	}
}elseif($action=='modify'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);
	}else{
			$newsInfo=array('title'=>$title,
							'classid'=>$classid,
							'author'=>$author,
							'source'=>$source,
							'keywords'=>$keywords,
							'description'=>$description,
							'content'=>$content
							);
		if($news->Update($id,$newsInfo)){
			$errormsg[]='更新新闻成功';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='更新新闻失败'.mysql_error();
			ShowMsg($errormsg,2,$back);
		}
	}	
}elseif($action=='delnews'){
	if($news->Delete($id)){
		$errormsg[]='删除数据成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='删除数据失败';
		ShowMsg($errormsg,2,$back);
	}
}
function checkinput(){
	global $errormsg,$title,$classid,$content,$issystem;
	if(strlen($title)==0){
		$errormsg[]='请填写新闻标题';
		$iserror=true;
	}
	if($classid==0 && !$issystem){
		$errormsg[]='请选择新闻类型';
		$iserror=true;
	}
	if(strlen($content)==0){
		$errormsg[]='请填写新闻内容';
		$iserror=true;
	}
	return $iserror;
}
?>