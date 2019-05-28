<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/product_class.php";
include "adminyz.php";

$pro=new Product(0);

//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('��Ʒ�б�'=>'product_list.php');
//��ʾ��Ϣ����

//��ҳΪ�������ŵ�ҳ��
if($action=='add'){
	$iserror=false;
	if(empty($title)){		
		$errormsg[]='����д��Ʒ����';
		$iserror=true;
	}
	if($classid==0){
		$errormsg[]='��ѡ���Ʒ���';
		$iserror=true;
	}
	if($iserror){
		ShowMsg($errormsg,2);
	}else{
		//û�д���
		//�ϴ���ƷͼƬ
		$logo=UplodeFile("logo",WEB_DR."/uploads/product/",'',array('width'=>$prologowidth,'height'=>$prologoheight));		
		$logo=basename($logo);
		$rid=$pro->Add(array('title'=>$title,
					   		 'logo'=>$logo,
					   		 'classid'=>$classid,
					   		 'keywords'=>$keywords,
					   		 'description'=>$description,
					   		 'content'=>$content
							 )
					   );
		if(!$rid){
			$errormsg[]='��Ӳ�Ʒʧ��';
			ShowMsg($errormsg,2);	
		}else{
			$errormsg[]='��Ӳ�Ʒ�ɹ�';
			$back['�������']='product_edit.php?action=add';
			ShowMsg($errormsg,1,$back);
		}
	}
}elseif($action=='modify'){	$iserror=false;
	if(empty($title)){		
		$errormsg[]='����д��Ʒ����';
		$iserror=true;
	}
	if($classid==0){
		$errormsg[]='��ѡ���Ʒ���';
		$iserror=true;
	}
	if($iserror){
		ShowMsg($errormsg,2);
	}
	$productinfo=array('title'=>$title,
					   'classid'=>$classid,
					   'keywords'=>$keywords,
					   'description'=>$description,
					   'content'=>$content
					  );
	$logo=UplodeFile("logo",WEB_DR."/uploads/product/",$pro->GetLogo($id,false),array('width'=>$prologowidth,'height'=>$prologoheight));
	if(strlen($logo)>0){
		$productinfo['logo']=basename($logo);
	}
	if($pro->Update($id,$productinfo)){
		$errormsg[]='���²�Ʒ�ɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='���²�Ʒʧ��';
		ShowMsg($errormsg,2);
	}	
}elseif($action=='delproduct'){
	if($pro->Delete($id)){
		$errormsg[]='ɾ�����ݳɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='ɾ������ʧ��';
		ShowMsg($errormsg,2,$back);
	}
}
?>