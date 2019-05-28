<?php
session_start();
include "../include/common.inc.php";
include WEB_CLASS."/config_class.php";
include "adminyz.php";

$config=new Config();

$msg=array();//信息

//本页为操作新闻的页面
if($action=='email'){
	$web_tiaoshi_new==0 && $web_tiaoshi_new=0.0;
	$web_bili_new==0 && $web_bili_new=0.0;
	$configArr=array(
					 'web_email_server'=>$web_email_server_new,
					 'web_email_usrename'=>$web_email_usrename_new,
					 'web_email_password'=>$web_email_password_new,
					 'web_email_port'=>$web_email_port_new,
					 'web_email_content'=>$web_email_content_new
					 );
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
	
}
?>