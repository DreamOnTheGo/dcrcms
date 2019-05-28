<?php
require_once("include/common.inc.php");
include WEB_DR."/common.php";

//提示信息开始
$errormsg=array();//错误信息
$back=array('首页'=>'index.'.$web_url_surfix);
//提示信息结束

include WEB_CLASS."/hudong_class.php";
$hudong=new HuDong();

if($action=='addorder'){
	$errormsg='';
	$iserror=false;
	if(empty($title)){
		$errormsg[]='请填写信息标题';
		$iserror=true;
	}
	if(empty($realname)){
		$errormsg[]='请填写您的姓名';
		$iserror=true;
	}
	if(empty($tel)){
		$errormsg[]='请填写您的联系方式';
		$iserror=true;
	}
	if($iserror){
		ShowMsg($errormsg,2);
	}else{
		//没有错误
		$fieldList=$hudong->GetFiledList(array('fieldname'));
		foreach($fieldList as $value){
			$hudongInfo[$value['fieldname']]=$$value['fieldname'];
		}
		$hudongInfo['title']=$title;
		if($hudong->Add($hudongInfo)){
			
			if($web_send_email)
			{			
				//发邮件
				require_once(WEB_CLASS.'/email_class.php');					
				$smtpemailto = $web_email_usrename;//发送给谁
				if('utf-8'==$web_code)
				{
					$mailsubject = iconv('utf-8','gb2312',"有人给您留言了_").date('Y-m-d');//邮件主题
				}else
				{
					$mailsubject = "有人给您留言了_".date('Y-m-d');//邮件主题
				}
				$mailbody = "标题：$title<br>";//邮件内容
				$mailbody .= "感兴趣的产品：$loveproduct<br>";//邮件内容
				$mailbody .= "姓名：$realname<br>";//邮件内容
				$mailbody .= "电话，E-mail：$tel<br>";//邮件内容
				$mailbody .= "详细地址：$address<br>";//邮件内容
				$mailbody .= "订单说明：$content<br>";//邮件内容
				$mailtype .= "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
			
				$smtp = new smtp($web_email_server,$web_email_port,true,$web_email_usrename,$web_email_password);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
				//$smtp->debug = TRUE;//是否显示发送的调试信息
				@$smtp->sendmail($smtpemailto, $web_email_usrename, $mailsubject, $mailbody, $mailtype);
				sleep(2);
			}
			
			$errormsg[]='添加订单成功';
			ShowMsg($errormsg,1,$back);
		}else{
			$errormsg[]='添加订单失败';
			ShowMsg($errormsg,2);
		}
	}

}
$fieldList=$hudong->GetFormatFiledList();
$tpl->assign('fieldList',$fieldList);
//p_r($fieldList);
$tpl->display('hudong.html');
?>