<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");

require_once(WEB_CLASS . "/class.news.php");
$cls_news = new cls_news();

$error_msg = array();//错误信息
$back = array('新闻列表'=>'news_list.php');

//本页为操作新闻的页面
if($action == 'add')
{
	if(checkinput()){
		show_msg($error_msg, 2, $back);
	}else{
		//没有错误
		require_once(WEB_CLASS . "/class.upload.php");
		$cls_upload = new cls_upload('logo');
		$file_info = $cls_upload->upload(WEB_DR . "/uploads/news/", '', array('width'=>$newslogowidth,'height'=>$newslogoheight));
		
		$logo = $file_info['sl_filename'];
		$news_info = array('title'=>$title,
						'classid'=>intval($classid),
						'istop'=>intval($istop),
						'click'=>intval($click),
				   		'logo'=>$logo,
						'author'=>$author,
						'source'=>$source,
						'addtime'=>time(),
						'updatetime'=>time(),
						'keywords'=>$keywords,
						'description'=>$description,
						'content'=>$content							
						);
		$aid = $cls_news->add($news_info);
		if(!$aid)
		{
			$error_msg[] = '插入新闻失败' . mysql_error();
			show_msg($error_msg, 2, $back);
		}else
		{
			$back['继续添加'] = 'news_edit.php?action=add';
			$error_msg[] = '插入新闻成功';
			show_msg($error_msg, 1, $back);
		}
	}
}else if($action == 'modify')
{
	if(checkinput())
	{
		show_msg($error_msg, 2, $back);
	}else
	{
		$news_info = array('title'=>$title,
						'classid'=>intval($classid),
						'istop'=>intval($istop),
						'click'=>intval($click),
						'author'=>$author,
						'source'=>$source,
						'updatetime'=>time(),
						'keywords'=>$keywords,
						'description'=>$description,
						'content'=>$content
						);
						
		require_once(WEB_CLASS . "/class.upload.php");
		$cls_upload = new cls_upload('logo');
		$file_info = $cls_upload->upload(WEB_DR . "/uploads/news/", '', array('width'=>$newslogowidth, 'height'=>$newslogoheight));
		
		$logo = $file_info['sl_filename'];
		if(strlen($logo)>0)
		{
			$news_info['logo'] = $logo;
		}
		if($cls_news->update($id, $news_info)){
			$error_msg[] = '更新新闻成功';
			show_msg($error_msg, 1, $back);
		}else{
			$error_msg[] = '更新新闻失败' . mysql_error();
			show_msg($error_msg, 2, $back);
		}
	}	
}else if($action == 'delnews')
{
	if($cls_news->delete($id))
	{
		$error_msg[] = '删除数据成功';
		show_msg($error_msg, 1, $back);
	}else
	{
		$error_msg[] = '删除数据失败';
		show_msg($error_msg, 2, $back);
	}
}else if($action == 'delsinglenews')
{
	if($cls_news->delete($id))
	{
		$error_msg[] = '删除数据成功';
		show_msg($error_msg, 1, $back);
	}else{
		$error_msg[]='删除数据失败';
		show_msg($error_msg,2,$back);
	}
}else if($action == 'top')
{
	$info = array(
				'istop'=>1
				);
	if($cls_news->update($id, $info)){
		$error_msg[] = '置顶成功';
		show_msg($error_msg, 1, $back);
	}else
	{
		$error_msg[] = '置顶失败' . mysql_error();
		show_msg($error_msg, 2, $back);
	}
}else if($action == 'top_no')
{
	$info = array(
				'istop'=>0
				);
	if($cls_news->update($id, $info)){
		$error_msg[] = '取消置顶成功';
		show_msg($error_msg, 1, $back);
	}else
	{
		$error_msg[] = '取消置顶失败' . mysql_error();
		show_msg($error_msg, 2, $back);
	}
}else
{
	echo '非法操作？';
}
function checkinput()
{
	global $error_msg,$title,$classid,$content,$issystem;
	if(strlen($title) == 0)
	{
		$error_msg[] = '请填写新闻标题';
		$iserror = true;
	}
	if($classid == 0){
		$error_msg[] = '请选择新闻类型';
		$iserror = true;
	}
	if(strlen($content) == 0){
		$error_msg[] = '请填写新闻内容';
		$iserror = true;
	}
	
	return $iserror;
}
?>