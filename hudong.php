<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('��ҳ'=>'index.php');
//��ʾ��Ϣ����

include WEB_CLASS."/hudong_class.php";
$hudong=new HuDong();

if($action=='addorder'){
	$errormsg='';
	$iserror=false;
	if(empty($title)){
		$errormsg[]='����д��Ϣ����';
		$iserror=true;
	}
	if(empty($realname)){
		$errormsg[]='����д��������';
		$iserror=true;
	}
	if(empty($tel)){
		$errormsg[]='����д������ϵ��ʽ';
		$iserror=true;
	}
	if($iserror){
		ShowMsg($errormsg,2);
	}else{
		//û�д���
		$fieldList=$hudong->GetFiledList(array('fieldname'));
		foreach($fieldList as $value){
			$hudongInfo[$value['fieldname']]=$$value['fieldname'];
		}
		$hudongInfo['title']=$title;
		if($hudong->Add($hudongInfo)){
			$errormsg[]='��Ӷ����ɹ�';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='��Ӷ���ʧ��';
			ShowMsg($errormsg,2);
		}
	}

}
$fieldList=$hudong->GetFormatFiledList();
$tpl->assign('fieldList',$fieldList);
//p_r($fieldList);
$tpl->display('hudong.html');
?>