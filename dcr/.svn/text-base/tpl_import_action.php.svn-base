<?php
include "../include/common.inc.php";
session_start();
include "adminyz.php";

include WEB_CLASS."/class.config.php";
include WEB_CLASS."/class.upload.php";

$config = new cls_config();

//得到配置文件
$cls_upload = new cls_upload('configfile');
$configFile = $cls_upload->upload(WEB_DR."/uploads/cache/");
include WEB_CLASS."/class.file.php";
$cls_file = new cls_file($configFile);
$configTxt = $cls_file->read();
$configArr = unserialize($configTxt);

$rs=$config->modify($configArr);
if($rs=='r1'){
	$msg[]='更新配置失败：配置项目请填写完整！';
	show_msg($msg,2);	
}
if($rs=='r2'){
	$msg[]='更新配置成功';
	show_msg($msg);	
}
if($rs=='r3'){
	$msg[]='更新配置失败：未知错误！';
	show_msg($msg,2);	
}
@unlink($configFile);
?>