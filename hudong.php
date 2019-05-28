<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

//提示信息开始
$errormsg=array();//错误信息
$back=array('首页'=>'index.php');
//提示信息结束

include WEB_CLASS."/hudong_class.php";
$hudong=new HuDong();

if($action=='addorder'){
	$errormsg='';
	$iserror=false;
	if(empty($title)){
		$errormsg[]='请填写信息标题';
		$iserror=true;
	}
	if(empty($realname)){
		$errormsg[]='请填写您的姓名';
		$iserror=true;
	}
	if(empty($tel)){
		$errormsg[]='请填写您的联系方式';
		$iserror=true;
	}
	if($iserror){
		ShowMsg($errormsg,2);
	}else{
		//没有错误
		$fieldList=$hudong->GetFiledList(array('fieldname'));
		foreach($fieldList as $value){
			$hudongInfo[$value['fieldname']]=$$value['fieldname'];
		}
		$hudongInfo['title']=$title;
		if($hudong->Add($hudongInfo)){
			$errormsg[]='添加订单成功';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='添加订单失败';
			ShowMsg($errormsg,2);
		}
	}

}
$fieldList=$hudong->GetFormatFiledList();
$tpl->assign('fieldList',$fieldList);
//p_r($fieldList);
$tpl->display('hudong.html');
?>