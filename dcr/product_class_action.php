<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/product_class.php";
include "adminyz.php";

header('cache-control:no-cache;must-revalidate');
$pro=new Product(0);

//提示信息开始
$errormsg=array();//错误信息
$back=array('产品分类列表'=>'product_class_list.php');
//提示信息结束

//本页为操作新闻的页面
if($action=='add' || $action=='add_ajax'){
	$errormsg='';
	$iserror=false;
	if(strlen($classname)==0){
		$errormsg[]='请填写产品分类名';
		$iserror=true;
	}
	if($iserror){
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
		$rid=$pro->AddClass(array('classname'=>$classname,
								  'parentid'=>(int)$parentid,
								  'orderid'=>(int)$orderid,
					   		 'classdescription'=>$classdescription
							 )
					   );
		if(!$rid){
			$errormsg[]='添加产品分类失败';
			if($action=='add'){
				ShowMsg($errormsg,2,$back);	
			}elseif($action='add_ajax'){
				echo implode(',',$errormsg).$classname;
			}
		}else{
			$errormsg[]='添加产品分类成功';
			if($action=='add'){
				$back['继续添加']='product_class_edit.php?action=add';
				ShowMsg($errormsg,1,$back);	
			}elseif($action='add_ajax'){
				echo implode(',',$errormsg);
			}
		}
	}
}elseif($action=='getlist_ajax'){
	$proclasslist=$pro->GetClassList();
	for($i=0;$i<count($proclasslist);$i++){
		$proclasslist[$i]['classname']=urlencode(iconv('gb2312','utf-8',$proclasslist[$i]['classname']));
	}
	//echo iconv('gb2312','utf-8',$proclasslist[0]['classname']);
	echo json_encode($proclasslist);	
}elseif($action=='modify'){
	if($pro->UpdateClass($id,array('classname'=>$classname,
								  'parentid'=>(int)$parentid,
								  'orderid'=>(int)$orderid,
					   		 'classdescription'=>$classdescription
							 ))){
		$errormsg[]='更新产品分类成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='更新产品分类失败';
		ShowMsg($errormsg,2,$back);
	}	
}elseif($action=='delproductclass'){
	$r_id=$pro->DeleteClass(array($classid));
	if($r_id==2){
		$errormsg[]='删除数据失败：请先删除这个类的子类';
		ShowMsg($errormsg,2,$back);
	}elseif($r_id==3){
		$errormsg[]='删除数据失败';
		ShowMsg($errormsg,2,$back);
	}elseif($r_id==1){
		$errormsg[]='删除数据成功';
		ShowMsg($errormsg,1,$back);
	}
}elseif($action=='order'){
	if($orderid){
		foreach($orderid as $key=>$value){
			$pro->UpdateClass($key,array('orderid'=>$value));
		}
	}
	$errormsg[]='更新排序成功';
	ShowMsg($errormsg,1,$back);
}else{
	ShowMsg('非法参数',2,$back);
}
?>