<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/hudong_class.php";

$hd=new HuDong();

//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('��Ϣ�ֶ��б�'=>'hudong_field_list.php');
//��ʾ��Ϣ����

//��ҳΪ�������ŵ�ҳ��
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
			$errormsg[]='�����Ϣ�ֶγɹ�';
			$back['�������']='hudong_field_edit.php?action=add';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='�����Ϣ�ֶ�ʧ��,���ܵ�ԭ���У�����ԭ��������ֶ�';
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
			$errormsg[]='�����ֶγɹ�';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='�����ֶ�ʧ��';
			ShowMsg($errormsg,2,$back);
		}
	}
}elseif($action=='delfield'){
	if($hd->DeleteField($id)){
		$errormsg[]='ɾ���ֶγɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='ɾ���ֶ�ʧ��';
		ShowMsg($errormsg,2,$back);
	}
}elseif($action=='order'){
	$idlist=$hd->GetFiledList(array('id'));
	foreach($idlist as $value){
		$sql="update {tablepre}hudong_field set orderid=".$orderid[$value['id']]." where id=".$value['id'];
		$db->ExecuteNoneQuery($sql);
	}
	$errormsg[]='�����ֶ�����ɹ�';
	ShowMsg($errormsg);
}
function checkinput(){
	global $errormsg,$itemname,$fieldname,$dtype,$vdefault;
	if(strlen($itemname)==0){
		$errormsg[]='����д����ʾ����';
		$iserror=true;
	}
	if(strlen($fieldname)==0){
		$errormsg[]='����д���ֶ�����';
		$iserror=true;
	}
	if(in_array($dtype,array('select','radio','checkbox'))){
		if(empty($vdefault)){
			$errormsg[]="���趨���ֶ�Ϊ {$dtype} ���ͣ�������Ĭ��ֵ��ָ��Ԫ���б��磺'a,b,c' ";
			$iserror=true;
		}
	}
	return $iserror;
}
?>