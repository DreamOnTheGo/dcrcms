<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
//导出模板
//把配置写到文件中 放到模板目录下去
$config=array(
			  'prologowidth'=>$prologowidth,
			  'prologoheight'=>$prologoheight,
			  'tpl_dir'=>$tpl_dir,
			  'web_cache_time'=>$web_cache_time,
			  'index_news_count'=>$index_news_count,
			  'index_product_count'=>$index_product_count,
			  'list_news_count'=>$list_news_count,
			  'list_product_count'=>$list_product_count
			  );
$config=serialize($config);
$filename=WEB_Tpl.$tpl_dir.DIRECTORY_SEPARATOR.'tpl.config';

include WEB_CLASS."/f_class.php";
$f=new FClass();
$f->setText($config);
$returnValue=$f->saveToFile($filename);
if($returnValue=='r1'){
	$msg[]="写入模板配置失败，路径不存在：$filename";
	ShowMsg($msg,2);
}elseif($returnValue=='r2'){
	$msg[]="写入模板配置失败，文件不可写：$filename";
	ShowMsg($msg,2);
}else{
	$msg[]="导出模板成功!";
	ShowMsg($msg);
}
?>