<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";//ģ��ͨ���ļ� ��ʼ��ģ���༰����ͨ�ñ���֮���

$classid=intval($classid);
if($classid>0){
	$where.="classid=$classid";
}
if(strlen($where)>0){
	$where='where '.$where;
}

//��Ʒ
$totalPage=0;//��ҳ��
$page=isset($page)?(int)$page:1;
$start=($page-1)*$list_product_count;

$pro=new Product();
$prolist=$pro->GetList($classid,array('id','title','logo'),$start,$list_product_count);
$tpl->assign('prolist',$prolist);

if($classid==0){
	$classname="��Ʒ����";
}else{
	$classname=$pro->GetClassName($classid);
}
$tpl->assign('classname',$classname);

//��ҳ
include WEB_CLASS."/page_class.php";
$sqlNum="select id from {tablepre}product $where";
$db->Execute($sqlNum);
$pageNum=$db->GetRsNum();
$totalPage=ceil($pageNum/$list_product_count);//��ҳ��

$page=new PageClass($page,$totalPage);
$fenye=$page->showPage();
$tpl->assign('fenye',$fenye);

$tpl->display('product_list.html');

?>