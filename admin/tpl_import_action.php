<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";

include WEB_CLASS."/config_class.php";

$config=new Config();

//�õ������ļ�
$configFile=UplodeFile("configfile",WEB_DR."/uploads/cache/");
include WEB_CLASS."/f_class.php";
$f=new FClass();
$configTxt=$f->getContent($configFile);
$configArr=unserialize($configTxt);

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
@unlink($configFile);
?>