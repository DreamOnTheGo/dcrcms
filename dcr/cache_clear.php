<?php
include "../include/common.inc.php";
session_start();
include WEB_CLASS."/class.dir.php";
include "adminyz.php";

$cls_dir = new cls_dir();

$cls_dir-> set_current_dir($dirname);
$cls_dir-> clear_dir();

$cls_dir-> clear_dir( WEB_CACHE, array('index.htm') );

$cls_dir-> clear_dir( WEB_CACHE  . "/template/{$tpl_dir}" );

$cls_dir-> delete_dir( WEB_CACHE  . "/template/{$tpl_dir}" );

//$cls_dir-> delete_dir( WEB_CACHE  . "/template" );
//@rmdir( WEB_CACHE  . "/template/{$tpl_dir}" );

show_msg('清空缓存成功');	
?>