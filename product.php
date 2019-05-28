<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";//模板通用文件 初始化模板类及载入通用变量之类的

$id=intval($id);
if($id>0){
}else{
	//提示信息开始
	$msg=array();//错误信息
	$back=array('产品列表'=>'product_list.php','首页'=>'index.php');
	//提示信息结束

	$msg[]='不存在这个产品信息！';
	ShowMsg($msg,2,$back);
}

$p=new Product(0);
$pro=$p->GetInfo($id,$productColList);
if(!$pro){
	//提示信息开始
	$msg=array();//错误信息
	$back=array('产品列表'=>'product_list.php','首页'=>'index.php');
	//提示信息结束

	$msg[]='不存在这个产品信息！';
	ShowMsg($msg,2,$back);
}
$tpl->assign('pro',$pro);

$tpl->display('product.html');

?>