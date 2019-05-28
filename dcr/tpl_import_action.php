<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/config_class.php";

$config=new Config();

//得到配置文件
$configFile=UplodeFile("configfile",WEB_DR."/uploads/cache/");
include WEB_CLASS."/f_class.php";
$f=new FClass();
$configTxt=$f->getContent($configFile);
$configArr=unserialize($configTxt);

$rs=$config->UpdateConfig($configArr);
if($rs=='r1'){
	$msg[]='更新配置失败：配置项目请填写完整！';
	ShowMsg($msg,2);	
}
if($rs=='r2'){
	$msg[]='更新配置成功';
	ShowMsg($msg);	
}
if($rs=='r3'){
	$msg[]='更新配置失败：未知错误！';
	ShowMsg($msg,2);	
}
@unlink($configFile);
?>