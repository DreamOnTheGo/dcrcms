<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/hudong_class.php";

$hd=new HuDong();

//提示信息开始
$errormsg=array();//错误信息
$back=array('信息字段列表'=>'hudong_field_list.php');
//提示信息结束

//本页为操作新闻的页面
if($action=='add'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);	
	}else{
		$hudongFieldInfo=array(
						 'itemname'=>$itemname,
						 'fieldname'=>$fieldname,
						 'dtype'=>$dtype,
						 'vdefault'=>$vdefault,
						 'maxlength'=>$maxlength
						 );
		if($hd->AddField($hudongFieldInfo)){
			$errormsg[]='添加信息字段成功';
			$back['继续添加']='hudong_field_edit.php?action=add';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='添加信息字段失败,可能的原因有：表中原来有这个字段';
			ShowMsg($errormsg,2,$back);
		}
	}
}elseif($action=='modify'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);	
	}else{
		$hudongFieldInfo=array(
						 'itemname'=>$itemname,
						 'fieldname'=>$fieldname,
						 'dtype'=>$dtype,
						 'vdefault'=>$vdefault,
						 'maxlength'=>$maxlength
						 );
		if($hd->UpdateField($id,$hudongFieldInfo)){
			$errormsg[]='更改字段成功';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='更改字段失败';
			ShowMsg($errormsg,2,$back);
		}
	}
}elseif($action=='delfield'){
	if($hd->DeleteField($id)){
		$errormsg[]='删除字段成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='删除字段失败';
		ShowMsg($errormsg,2,$back);
	}
}elseif($action=='order'){
	$idlist=$hd->GetFiledList(array('id'));
	foreach($idlist as $value){
		$sql="update {tablepre}hudong_field set orderid=".$orderid[$value['id']]." where id=".$value['id'];
		$db->ExecuteNoneQuery($sql);
	}
	$errormsg[]='更新字段排序成功';
	ShowMsg($errormsg);
}
function checkinput(){
	global $errormsg,$itemname,$fieldname,$dtype,$vdefault;
	if(strlen($itemname)==0){
		$errormsg[]='请填写表单提示文字';
		$iserror=true;
	}
	if(strlen($fieldname)==0){
		$errormsg[]='请填写表单字段名称';
		$iserror=true;
	}
	if(in_array($dtype,array('select','radio','checkbox'))){
		if(empty($vdefault)){
			$errormsg[]="你设定了字段为 {$dtype} 类型，必须在默认值中指定元素列表，如：'a,b,c' ";
			$iserror=true;
		}
	}
	return $iserror;
}
?>