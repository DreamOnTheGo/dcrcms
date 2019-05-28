<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/product_class.php";
include "adminyz.php";

header('Content-type:text/html;charset=gb2312');
header('cache-control:no-cache;must-revalidate');
$pro=new Product(0);

//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('��Ʒ�����б�'=>'product_class_list.php');
//��ʾ��Ϣ����

//��ҳΪ�������ŵ�ҳ��
if($action=='add' || $action=='add_ajax'){
	$errormsg='';
	$iserror=false;
	if(strlen($classname)==0){
		$errormsg[]='����д��Ʒ������';
		$iserror=true;
	}
	if($iserror){
		if($action=='add'){
			ShowMsg($errormsg,2,$back);	
		}elseif($action='add_ajax'){
			echo implode(',',$errormsg);
		}
	}else{
		//û�д���
		if($action=='add_ajax'){
			$classname=iconv('utf-8','gb2312',urldecode($classname));
			$classdescription=iconv('utf-8','gb2312',urldecode($classdescription));
		}
		$rid=$pro->AddClass(array('classname'=>$classname,
					   		 'classdescription'=>$classdescription
							 )
					   );
		if(!$rid){
			$errormsg[]='��Ӳ�Ʒ����ʧ��';
			if($action=='add'){
				ShowMsg($errormsg,2,$back);	
			}elseif($action='add_ajax'){
				echo implode(',',$errormsg).$classname;
			}
		}else{
			$errormsg[]='��Ӳ�Ʒ����ɹ�';
			if($action=='add'){
				ShowMsg($errormsg,1,$back);	
			}elseif($action='add_ajax'){
				echo implode(',',$errormsg);
			}
		}
	}
}elseif($action=='getlist_ajax'){
	$proclasslist=$pro->GetClassList(array('id','classname'));
	for($i=0;$i<count($proclasslist);$i++){
		$proclasslist[$i]['classname']=urlencode(iconv('gb2312','utf-8',$proclasslist[$i]['classname']));
	}
	//echo iconv('gb2312','utf-8',$proclasslist[0]['classname']);
	echo json_encode($proclasslist);	
}elseif($action=='modify'){
	if($pro->UpdateClass($id,array('classname'=>$classname,
					   		 'classdescription'=>$classdescription
							 ))){
		$errormsg[]='���²�Ʒ����ɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='���²�Ʒ����ʧ��';
		ShowMsg($errormsg,2,$back);
	}	
}elseif($action=='delproductclass'){
	if($pro->DeleteClass($id)){
		$errormsg[]='ɾ�����ݳɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='ɾ������ʧ��';
		ShowMsg($errormsg,2,$back);
	}
}
?>