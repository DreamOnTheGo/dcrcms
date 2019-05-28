<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";//模板通用文件 初始化模板类及载入通用变量之类的

$classid=intval($classid);
if($classid>0){
	$where.="classid=$classid";
}
if(strlen($where)>0){
	$where='where '.$where;
}

//产品
$totalPage=0;//总页数
$page=isset($page)?(int)$page:1;
$start=($page-1)*$list_product_count;

$pro=new Product();
$prolist=$pro->GetList($classid,array('id','title','logo'),$start,$list_product_count,'id desc','',1);
$tpl->assign('prolist',$prolist);

if($classid==0){
	$classname="产品中心";
	$position='首页>>产品中心';
}else{
	$class_info=$pro->GetClassInfo($classid);
	$classname=$class_info['classname'];
	$position=$class_info['position'];
}
$tpl->assign('classname',$classname);
$tpl->assign('position',$position);

//分页
include WEB_CLASS."/page_class.php";
$pageNum=count($pro->GetList($classid,array('id'),'','','','',1));
$totalPage=ceil($pageNum/$list_product_count);//总页数

$page=new PageClass($page,$totalPage);
$fenye=$page->showPage();
$tpl->assign('fenye',$fenye);

$tpl->display('product_list.html');

?>