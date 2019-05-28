<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS.'article_class.php';
$art=new Article('{tablepre}flink');
//提示信息开始
$errormsg=array();//错误信息
$back=array('友情链接列表'=>'flink_list.php');
//提示信息结束

//本页为操作新闻的页面
if($action=='addflink'){
		//没有错误
		$logo=UplodeFile("logo",WEB_DR."/uploads/flink/",'',array('width'=>$flinklogowidth,'height'=>$flinklogoheight));
		$logo=basename($logo);
		$info=array('webname'=>$webname,
					   		'logo'=>$logo,
							'weburl'=>$weburl,
							'addtime'=>time(),
							'updatetime'=>time()
							);
		$aid=$art->Add($info);
		if(!$aid){
			$errormsg[]='添加友情链接失败'.mysql_error();
			ShowMsg($errormsg,2,$back);	
		}else{
			$back['继续添加']='flink_edit.php?action=add';
			$errormsg[]='添加友情链接成功';
			ShowMsg($errormsg,1,$back);
		}
		//echo mysql_error();
}elseif($action=='editflink')
{
			$info=array('webname'=>$webname,
						'weburl'=>$weburl,
						'updatetime'=>time()
						);
		include_once(WEB_CLASS."/upload_class.php");
		$upload=new Upload();
		$fileInfo=$upload->UploadFile("logo",WEB_DR."/uploads/flink/",'',array('width'=>$flinklogowidth,'height'=>$flinklogoheight));
		$logo=basename($fileInfo['sl_filename']);
			if(strlen($logo)>0){
				$info['logo']=basename($logo);
			}
		if($art->Update($info,"id=$id")){
			$errormsg[]='更新链接成功';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='更新链接失败'.mysql_error();
			ShowMsg($errormsg,2,$back);
		}
}
elseif($action=='delflink'){
	$info=$art->GetInfo(array('logo'),"id=$id");
	@unlink('../uploads/logo/'.$info['logo']);
	if($art->Del(array($id))){
		$errormsg[]='删除数据成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='删除数据失败';
		ShowMsg($errormsg,2,$back);
	}
}else{
	echo '非法操作？';
}
?>