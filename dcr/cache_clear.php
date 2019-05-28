<?php
include "../include/common.inc.php";
session_start();
include WEB_CLASS."/class.dir.php";
include "adminyz.php";
include WEB_DR."/common.php";//模板通用文件 初始化模板类及载入通用变量之类的

$dirname = $tpl->compile_dir;

$cls_dir = new cls_dir($dirname);
$cls_dir ->clear_dir();

$dirname = $tpl->cache_dir;

$cls_dir-> set_current_dir($dirname);
$cls_dir-> clear_dir();

$cls_dir-> set_current_dir(WEB_CACHE);
$cls_dir-> clear_dir(WEB_CACHE, array('index.htm'));

$tpl->clear_all_cache();

show_msg('清空缓存成功');	
?>