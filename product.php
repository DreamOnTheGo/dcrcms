<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";//ģ��ͨ���ļ� ��ʼ��ģ���༰����ͨ�ñ���֮���

$id=intval($id);
if($id>0){
}else{
	//��ʾ��Ϣ��ʼ
	$msg=array();//������Ϣ
	$back=array('��Ʒ�б�'=>'product_list.php','��ҳ'=>'index.php');
	//��ʾ��Ϣ����

	$msg[]='�����������Ʒ��Ϣ��';
	ShowMsg($msg,2,$back);
}

$p=new Product(0);
$pro=$p->GetInfo($id,$productColList);
if(!$pro){
	//��ʾ��Ϣ��ʼ
	$msg=array();//������Ϣ
	$back=array('��Ʒ�б�'=>'product_list.php','��ҳ'=>'index.php');
	//��ʾ��Ϣ����

	$msg[]='�����������Ʒ��Ϣ��';
	ShowMsg($msg,2,$back);
}
$tpl->assign('pro',$pro);

$tpl->display('product.html');

?>