<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/config_class.php";
include "adminyz.php";

$config=new Config();

$msg=array();//��Ϣ

//��ҳΪ�������ŵ�ҳ��
if($action=='updateconfig'){
	$configArr=array(
					 'web_url'=>$web_url_new,
					 'web_name'=>$web_name_new,
					 'web_tiaoshi'=>$web_tiaoshi_new
					 );
	$rs=$config->UpdateConfig($configArr);
	if($rs=='r1'){
		$msg[]='��������ʧ�ܣ�������Ŀ����д������';
		ShowMsg($msg,2);	
	}
	if($rs=='r2'){
		$msg[]='�������óɹ�';
		ShowMsg($msg);	
	}
	if($rs=='r3'){
		$msg[]='��������ʧ�ܣ�δ֪����';
		ShowMsg($msg,2);	
	}
	
}
if($action=='updateconfig_tpl'){
	$newslogowidth_new==0 && $newslogowidth_new=0.0;
	$newslogoheight_new==0 && $newslogoheight_new=0.0;
	$prologowidth_new==0 && $prologowidth_new=0.0;
	$prologoheight_new==0 && $prologoheight_new=0.0;
	$web_cache_time_new==0 && $web_cache_time_new=0.0;
	$index_news_count_new==0 && $index_news_count_new=0.0;
	$index_product_count_new==0 && $index_product_count_new=0.0;
	$list_product_count_new==0 && $list_product_count_new=0.0;
	$configArr=array(
					 'newslogowidth'=>$newslogowidth_new,
					 'newslogoheight'=>$newslogoheight_new,
					 'prologowidth'=>$prologowidth_new,
					 'prologoheight'=>$prologoheight_new,
					 'tpl_dir'=>$tpl_dir_new,
					 'web_cache_time'=>$web_cache_time_new,
					 'index_news_count'=>$index_news_count_new,
					 'index_product_count'=>$index_product_count_new,
					 'list_news_count'=>$list_news_count_new,
					 'list_product_count'=>$list_product_count_new
					 );
	$rs=$config->UpdateConfig($configArr);
	if($rs=='r1'){
		$msg[]='��������ʧ�ܣ�������Ŀ����д������';
		ShowMsg($msg,2);	
	}
	if($rs=='r2'){
		$msg[]='�������óɹ�';
		ShowMsg($msg);	
	}
	if($rs=='r3'){
		$msg[]='��������ʧ�ܣ�δ֪����';
		ShowMsg($msg,2);	
	}
	
}
?>