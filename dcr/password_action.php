<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/product_class.php";
include "adminyz.php";

//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('�����б�'=>'news_list.php');
//��ʾ��Ϣ����

//��ҳΪ�������ŵ�ҳ��
if($action=='changpas'){
	$errormsg='';
	$iserror=false;
	$m_cp=new Member_Admin($admin_u,jiami($oldpassword));
	if(!$m_cp->yz()){
		$errormsg[]='ԭ�������';
		$iserror=true;
	}
	if(strlen($newpassword1)<4 || strlen($newpassword1)>16){
		$errormsg[]='�����볤��Ӧ����4-16֮��';
		$iserror=true;
	}
	if($newpassword1!=$newpassword2){
		$errormsg[]='������ǰ�����벻һ��';
		$iserror=true;
	}
	if($iserror){
		ShowMsg($errormsg,2);
	}else{
		if(!$m_cp->changpas($newpassword1)){
			$errormsg[]='�޸�����ʧ��';
			ShowMsg($errormsg,2);		
		}else{
			$m_cp->logout();
			$errormsg[]='�޸�����ɹ�,�����µ�½';
			ShowMsg($errormsg,1);
		}
	}
}
?>