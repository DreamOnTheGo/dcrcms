<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
</head>
<BODY>
<DIV id="content">
<form action="email_action.php" method="post">
<input type="hidden" name="action" id="action" value="email">
<UL class=Form_Advance id=FormRegStep1>
  <LI class=Title>网站邮件配置</LI>
  <LI class=Seperator>
    <HR>
  </LI>
  <LI>
  <DIV class=Hint>邮箱SMTP：</DIV>
  <DIV class=FormInput>
    <input id="web_email_server_new" size="24" class="Warning" name="web_email_server_new"  value="<?php echo $web_email_server; ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt"></div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <li>
        <DIV class=Hint>邮箱帐号：</DIV>
        <DIV class=FormInput>
          <input id="web_dir_new" size="24" class="Warning" name="web_email_usrename_new"  value="<?php echo $web_email_usrename; ?>" />
        </DIV>
        <div class="Info">
          <div class="alert_txt"></div>
        </div>
        <DIV class=HackBox></DIV>
      </LI>
  <LI>
  <DIV class=Hint>邮箱密码：</DIV>
  <DIV class=FormInput>
    <input name="web_email_password_new" type="password" class="Warning" id="web_name_new" value="<?php echo $web_email_password ?>" size="24" />
  </DIV>
  <div class="Info">
    <div class="alert_txt"></div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <LI>
  <DIV class=Hint>SMTP端口：</DIV>
  <DIV class=FormInput>
    <input id="web_name_new2" size="24" class="Warning" name="web_email_port_new" value="<?php echo $web_email_port ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt"></div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li>
  <LI class=SubmitBox><INPUT class="btn" type=submit value="修改配置" name=Submit></LI></UL>
 </form>
</DIV>
 </BODY></HTML>