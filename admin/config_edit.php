<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
</HEAD>
<BODY>
<DIV id="content">
<form action="config_action.php" method="post">
<input type="hidden" name="action" id="action" value="updateconfig">
<UL class=Form_Advance id=FormRegStep1>
  <LI class=Title>�޸���վ����</LI>
  <LI class=Seperator>
    <HR>
  </LI>
  <LI>
  <DIV class=Hint>��ַ��ַ��</DIV>
  <DIV class=FormInput>
    <input id="web_url_new" size="24" class="Warning" name="web_url_new"  value="<?php echo $web_url ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt">��վ��ַ���벻Ҫ��/</div>
  </div>
  <DIV class=HackBox></DIV></LI>  <LI>
  <DIV class=Hint>��վ���ƣ�</DIV>
  <DIV class=FormInput>
    <input id="web_name_new" size="24" class="Warning" name="web_name_new" value="<?php echo $web_name ?>" />
  </DIV>
  <div class="Info">
    <div class="alert_txt">��վ����</div>
  </div>
  <DIV class=HackBox></DIV></LI>
  <li class="Seperator"><hr></li>
  <LI class=SubmitBox><INPUT class="btn" type=submit value="�޸�����" name=Submit></LI></UL>
 </form>
</DIV>
 </BODY></HTML>