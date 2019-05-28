<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/config_class.php";
include "adminyz.php";
include WEB_DR."/common.php";//模板通用文件 初始化模板类及载入通用变量之类的

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
$errormsg[]='清空缓存成功';
ShowMsg($errormsg);	
?>