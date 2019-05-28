<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/news_class.php";

header('Content-type:text/html;charset=gb2312');
header('cache-control:no-cache;must-revalidate');
$news=new News();

//提示信息开始
$errormsg=array();//错误信息
$back=array('新闻分类列表'=>'news_class_list.php');
//提示信息结束

//本页为操作新闻的页面
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
		//没有错误
		if($action=='add_ajax'){
			$classname=iconv('utf-8','gb2312',urldecode($classname));
			$classdescription=iconv('utf-8','gb2312',urldecode($classdescription));
		}
		$rid=$news->AddClass(array('classname'=>$classname,
					   		 'classdescription'=>$classdescription
							 )
					   );
		if(!$rid){
			$errormsg[]='添加新闻分类失败';
			if($action=='add'){
				ShowMsg($errormsg,2,$back);	
			}elseif($action='add_ajax'){
				echo implode(',',$errormsg).$classname;
			}
		}else{
			$errormsg[]='添加新闻分类成功';
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
			$errormsg[]='更新新闻分类成功';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='更新新闻分类失败';
			ShowMsg($errormsg,2,$back);
		}
	}
}elseif($action=='delnewsclass'){
	if($news->DeleteClass($id)){
		$errormsg[]='删除数据成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='删除数据失败';
		ShowMsg($errormsg,2,$back);
	}
}
function checkinput(){
	global $errormsg,$classname;
	if(strlen($classname)==0){
		$errormsg[]='请填写新闻分类名';
		$iserror=true;
	}
	return $iserror;
}
?>