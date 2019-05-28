<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/product_class.php";
include "adminyz.php";

$pro=new Product(0);

//提示信息开始
$errormsg=array();//错误信息
$back=array('产品列表'=>'product_list.php');
//提示信息结束

//本页为操作新闻的页面
if($action=='add'){
	$iserror=false;
	if(empty($title)){		
		$errormsg[]='请填写产品名称';
		$iserror=true;
	}
	if($classid==0){
		$errormsg[]='请选择产品类别';
		$iserror=true;
	}
	if($iserror){
		ShowMsg($errormsg,2);
	}else{
		//没有错误
		//上传产品图片
		include_once(WEB_CLASS."/upload_class.php");
		$upload=new Upload();
		$fileInfo=$upload->UploadFile("logo",WEB_DR."/uploads/product/",'',array('width'=>$prologowidth,'height'=>$prologoheight,'newpic'=>1));
		$logo=basename($fileInfo['sl_filename']);
		$biglogo=basename($fileInfo['filename']);
		$rid=$pro->Add(array('title'=>$title,
					   		 'logo'=>$logo,
					   		 'biglogo'=>$biglogo,
							 'tags'=>$tags,
					   		 'classid'=>intval($classid),
							 'istop'=>intval($istop),
					   		 'keywords'=>$keywords,
					   		 'description'=>$description,
					   		 'content'=>$content
							 )
					   );
		if(!$rid){
			$errormsg[]='添加产品失败';
			ShowMsg($errormsg,2);	
		}else{			
			//处理tags
			$tagslist=explode(',',$tags);
			if($tagslist)
			{
				$tagindex_art=APP::GetArticle('{tablepre}tagindex');
				$taglist_art=APP::GetArticle('{tablepre}taglist');
				foreach($tagslist as $taginfo)
				{
					if(!empty($taginfo))
					{
						$tag_list_info=array(
											 'aid'=>$rid,
											 'typeid'=>intval($classid),
											 'tag'=>$taginfo
											 );
						$taglist_art->Add($tag_list_info);
						//删除原来的记录再添加	
						$sql="delete from {tablepre}tagindex where tag='$taginfo'";
						$db->ExecuteNoneQuery($sql);
						$tag_total=$taglist_art->GetListCount("tag='$taginfo'");
						$tag_index_info=array(
									   'tag'=>$taginfo,
									   'total'=>$tag_total,
									   'addtime'=>time()
									   );
						$tagindex_art->Add($tag_index_info);
					}
				}
				unset($tagindex_art,$taglist_art);
			}
			$errormsg[]='添加产品成功';
			$back['继续添加']='product_edit.php?action=add';
			ShowMsg($errormsg,1,$back);
		}
	}
}elseif($action=='modify'){	$iserror=false;
	if(empty($title)){		
		$errormsg[]='请填写产品名称';
		$iserror=true;
	}
	if($classid==0){
		$errormsg[]='请选择产品类别';
		$iserror=true;
	}
	if($iserror){
		ShowMsg($errormsg,2);
	}
	$productinfo=array('title'=>$title,
					   'classid'=>intval($classid),
					   'istop'=>intval($istop),
					   'tags'=>$tags,
					   'keywords'=>$keywords,
					   'description'=>$description,
					   'content'=>$content
					  );
	include_once(WEB_CLASS."/upload_class.php");
		$upload=new Upload();
	$fileInfo=$upload->UploadFile("logo",WEB_DR."/uploads/product/",$pro->GetLogo($id,false),array('width'=>$prologowidth,'height'=>$prologoheight,'newpic'=>1));
	
	if(strlen($fileInfo)>0){
		$logo=basename($fileInfo['sl_filename']);
		$biglogo=basename($fileInfo['filename']);
		$productinfo['logo']=basename($logo);
		$productinfo['biglogo']=basename($biglogo);
	}
	if($pro->Update($id,$productinfo)){
		//处理旧的tags 先减一次
		if(!empty($oldtags))
		{
			$olg_tags_list=explode(',',$oldtags);
			if($olg_tags_list)
			{
				foreach($olg_tags_list as $old_tag)
				{
					$sql="update {tablepre}tagindex set total=total-1 where tag='".$old_tag."'";
					//echo $sql;
					$db->ExecuteNoneQuery($sql);
				}
			}
		}
		$tagslist=explode(',',$tags);
		if($tagslist)
		{
			//先清空tag_list下产品的tags
			$sql="delete from {tablepre}taglist where aid=$id";
			$db->ExecuteNoneQuery($sql);
			$tagindex_art=APP::GetArticle('{tablepre}tagindex');
			$taglist_art=APP::GetArticle('{tablepre}taglist');
			foreach($tagslist as $taginfo)
			{
				if(!empty($taginfo))
				{
					$tag_list_info=array(
										 'aid'=>$id,
										 'typeid'=>intval($classid),
										 'tag'=>$taginfo
										 );
					$taglist_art->Add($tag_list_info);
					//原来的记录加一次
					if($db->GetFieldValue('{tablepre}tagindex','id',"tag='".$taginfo."'"))
					{
						$sql="update {tablepre}tagindex set total=total+1 where tag='".$taginfo."'";
						$db->ExecuteNoneQuery($sql);
					}else
					{
						$tag_index_info=array(
									   'tag'=>$taginfo,
									   'total'=>1,
									   'addtime'=>time()
									   );
						$tagindex_art->Add($tag_index_info);
					}
				}
			}
			unset($tagindex_art,$taglist_art);
		}
		$errormsg[]='更新产品成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='更新产品失败';
		ShowMsg($errormsg,2);
	}	
}elseif($action=='delproduct'){
	$r=$pro->Delete($id);
	if($r==1){
		$errormsg[]='删除数据成功';
		ShowMsg($errormsg,1,$back);
	}elseif($r==3){
		$errormsg[]='删除数据失败:没有选择要删除的产品';
		ShowMsg($errormsg,2,$back);
	}elseif($r==2){
		$errormsg[]='删除数据失败:处理数据库数据时失败';
		ShowMsg($errormsg,2,$back);
	}
}elseif($action=='delsingleproduct'){
	$r=$pro->Delete(array($id));
	if($r==1){
		$errormsg[]='删除数据成功';
		ShowMsg($errormsg,1,$back);
	}elseif($r==3){
		$errormsg[]='删除数据失败:没有选择要删除的产品';
		ShowMsg($errormsg,2,$back);
	}elseif($r==2){
		$errormsg[]='删除数据失败:处理数据库数据时失败';
		ShowMsg($errormsg,2,$back);
	}
}elseif($action=='top'){
	$info=array(
				'istop'=>1
				);
	if($pro->Update($id,$info)){
		$errormsg[]='置顶成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='置顶失败'.mysql_error();
		ShowMsg($errormsg,2,$back);
	}
}elseif($action=='top_no'){
	$info=array(
				'istop'=>0
				);
	if($pro->Update($id,$info)){
		$errormsg[]='取消置顶成功';
		ShowMsg($errormsg,1,$back);
	}else{
		$errormsg[]='取消置顶失败'.mysql_error();
		ShowMsg($errormsg,2,$back);
	}
}else{
	echo '非法操作？';
}
?>