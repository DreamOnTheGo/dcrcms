<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/single_class.php";
$single=new Single;
//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('��˾����'=>'single_list.php');
//��ʾ��Ϣ����

//��ҳΪ�������ŵ�ҳ��
if($action=='add'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);
	}else{
		//û�д���
		$singleInfo=array('title'=>$title,
						'content'=>$content
						);
		
		$aid=$single->Add($singleInfo);
		if(!$aid){
			$errormsg[]='��ӵ�ҳ��ʧ��'.mysql_error();
			ShowMsg($errormsg,2,$back);	
		}else{
			$errormsg[]='��ӵ�ҳ��ɹ�';
			$back['�������']='single_edit.php?action=add';
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
			$errormsg[]='���µ�ҳ��ɹ�';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='���µ�ҳ��ʧ��'.mysql_error();
			ShowMsg($errormsg,2,$back);
		}
	}	
}elseif($action=='delsingle'){
	if($single->Delete($id)){
		$errormsg[]='ɾ�����ݳɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='ɾ������ʧ��';
		ShowMsg($errormsg,2,$back);
	}
}
function checkinput(){
	global $errormsg,$title,$content;
	if(strlen($title)==0){
		$errormsg[]='����д���ϱ���';
		$iserror=true;
	}
	if(strlen($content)==0){
		$errormsg[]='����д��������';
		$iserror=true;
	}
	return $iserror;
}
?>