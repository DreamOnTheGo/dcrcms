<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
//����ģ��
//������д���ļ��� �ŵ�ģ��Ŀ¼��ȥ
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
	$msg[]="д��ģ������ʧ�ܣ�·�������ڣ�$filename";
	ShowMsg($msg,2);
}elseif($returnValue=='r2'){
	$msg[]="д��ģ������ʧ�ܣ��ļ�����д��$filename";
	ShowMsg($msg,2);
}else{
	$msg[]="����ģ��ɹ�!";
	ShowMsg($msg);
}
?>