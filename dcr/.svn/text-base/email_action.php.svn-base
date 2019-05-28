<?php
include "../include/common.inc.php";
session_start();
include WEB_CLASS."/class.config.php";
include "adminyz.php";

$config = new cls_config();

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
	
}
?>