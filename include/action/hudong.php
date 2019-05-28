<?php

require_once("include/common.inc.php");

require_once(WEB_CLASS."/class.hudong.php");
$cls_hudong = new cls_hudong();

if($action == 'addorder')
{
	$error_msg = '';
	$iserror = false;
	if(empty($title))
	{
		$error_msg[] = '请填写信息标题';
		$iserror = true;
	}
	if(empty($realname))
	{
		$error_msg[] = '请填写您的姓名';
		$iserror = true;
	}
	if(empty($tel))
	{
		$error_msg[] = '请填写您的联系方式';
		$iserror = true;
	}
	if($iserror)
	{
		show_msg($error_msg, 2);
	}else
	{
		//没有错误
		$field_list = $cls_hudong->get_filed_list(array('col'=>'fieldname'));
		foreach($field_list as $value)
		{
			$hudong_info[$value['fieldname']] = strip_tags($$value['fieldname']);
		}
		$hudong_info['title'] = $title;
		if($cls_hudong->add($hudong_info))
		{
			
			if($web_send_email)
			{			
				//发邮件
				require_once(WEB_CLASS . '/class.email.php');					
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
			
			show_msg('添加订单成功', 1, $back);
		}else{
			show_msg('添加订单失败', 2);
		}
	}

}

?>