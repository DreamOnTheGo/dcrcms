<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/news_class.php";
$news=new News;
//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('�����б�'=>'news_list.php');
//��ʾ��Ϣ����

//��ҳΪ�������ŵ�ҳ��
if($action=='add'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);
	}else{
		//û�д���
			$newsInfo=array('title'=>$title,
							'classid'=>$classid,
							'author'=>$author,
							'source'=>$source,
							'keywords'=>$keywords,
							'description'=>$description,
							'content'=>$content
							);
		$aid=$news->Add($newsInfo);
		if(!$aid){
			$errormsg[]='��������ʧ��'.mysql_error();
			ShowMsg($errormsg,2,$back);	
		}else{
			$errormsg[]='�������ųɹ�';
			ShowMsg($errormsg,1,$back);
		}
	}
}elseif($action=='modify'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);
	}else{
			$newsInfo=array('title'=>$title,
							'classid'=>$classid,
							'author'=>$author,
							'source'=>$source,
							'keywords'=>$keywords,
							'description'=>$description,
							'content'=>$content
							);
		if($news->Update($id,$newsInfo)){
			$errormsg[]='�������ųɹ�';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='��������ʧ��'.mysql_error();
			ShowMsg($errormsg,2,$back);
		}
	}	
}elseif($action=='delnews'){
	if($news->Delete($id)){
		$errormsg[]='ɾ�����ݳɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='ɾ������ʧ��';
		ShowMsg($errormsg,2,$back);
	}
}
function checkinput(){
	global $errormsg,$title,$classid,$content,$issystem;
	if(strlen($title)==0){
		$errormsg[]='����д���ű���';
		$iserror=true;
	}
	if($classid==0 && !$issystem){
		$errormsg[]='��ѡ����������';
		$iserror=true;
	}
	if(strlen($content)==0){
		$errormsg[]='����д��������';
		$iserror=true;
	}
	return $iserror;
}
?>