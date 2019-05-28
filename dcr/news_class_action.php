<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/news_class.php";

header('Content-type:text/html;charset=gb2312');
header('cache-control:no-cache;must-revalidate');
$news=new News();

//��ʾ��Ϣ��ʼ
$errormsg=array();//������Ϣ
$back=array('���ŷ����б�'=>'news_class_list.php');
//��ʾ��Ϣ����

//��ҳΪ�������ŵ�ҳ��
if($action=='add' || $action=='add_ajax'){
	$errormsg='';
	$iserror=false;
	if(checkinput()){
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
		$rid=$news->AddClass(array('classname'=>$classname,
					   		 'classdescription'=>$classdescription
							 )
					   );
		if(!$rid){
			$errormsg[]='������ŷ���ʧ��';
			if($action=='add'){
				ShowMsg($errormsg,2,$back);	
			}elseif($action='add_ajax'){
				echo implode(',',$errormsg).$classname;
			}
		}else{
			$errormsg[]='������ŷ���ɹ�';
			if($action=='add'){
				ShowMsg($errormsg,1,$back);	
			}elseif($action='add_ajax'){
				echo implode(',',$errormsg);
			}
		}
	}
}elseif($action=='getlist_ajax'){
	$classlist=$news->GetClassList(array('id','classname'));
	for($i=0;$i<count($classlist);$i++){
		$classlist[$i]['classname']=urlencode(iconv('gb2312','utf-8',$classlist[$i]['classname']));
	}
	//echo iconv('gb2312','utf-8',$proclasslist[0]['classname']);
	echo json_encode($classlist);	
}elseif($action=='modify'){
	if(checkinput()){
		ShowMsg($errormsg,2,$back);	
	}else{
		if($news->UpdateClass($id,array('classname'=>$classname,
								 'classdescription'=>$classdescription
								 ))){
			$errormsg[]='�������ŷ���ɹ�';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='�������ŷ���ʧ��';
			ShowMsg($errormsg,2,$back);
		}
	}
}elseif($action=='delnewsclass'){
	if($news->DeleteClass($id)){
		$errormsg[]='ɾ�����ݳɹ�';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='ɾ������ʧ��';
		ShowMsg($errormsg,2,$back);
	}
}
function checkinput(){
	global $errormsg,$classname;
	if(strlen($classname)==0){
		$errormsg[]='����д���ŷ�����';
		$iserror=true;
	}
	return $iserror;
}
?>