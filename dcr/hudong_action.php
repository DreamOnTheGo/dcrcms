<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/hudong_class.php";
include "adminyz.php";

//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('������Ϣ�б�'=>'hudong_list.php');
//��ʾ��Ϣ����

//��ҳΪ�������ŵ�ҳ��
$hudong=new HuDong(0);
if($action=='delorder'){
	if($hudong->Delete($id)){
		$errormsg[]='ɾ�����ݳɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='ɾ������ʧ��';
		ShowMsg($errormsg,1,$back);
	}
}elseif($action=='change_type_1'){
	if($hudong->UpdateType($id,1)){
		$errormsg[]='���»�����Ϣ״̬�ɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='���»�����Ϣʧ��';
		ShowMsg($errormsg,1,$back);
	}
	
}elseif($action=='change_type_2'){
	if($hudong->UpdateType($id,2)){
		$errormsg[]='���»�����Ϣ״̬�ɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='���»�����Ϣʧ��';
		ShowMsg($errormsg,1,$back);
	}
}
?>