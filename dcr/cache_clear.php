<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/config_class.php";
include "adminyz.php";
include WEB_DR."/common.php";//ģ��ͨ���ļ� ��ʼ��ģ���༰����ͨ�ñ���֮���

$dirname=$tpl->compile_dir;

if($handle=opendir($dirname)){
	while(false!==($file=readdir($handle))){
    	if($file!="."&&$file!=".."){
        	unlink($dirname.$file);   
		}   
	}   
	closedir($handle);   
}

$dirname=$tpl->cache_dir;

if($handle=opendir($dirname)){
	while(false!==($file=readdir($handle))){
    	if($file!="."&&$file!=".."){
        	unlink($dirname.$file);   
		}   
	}   
	closedir($handle);   
}

$tpl->clear_all_cache();
$errormsg[]='��ջ���ɹ�';
ShowMsg($errormsg);	
?>