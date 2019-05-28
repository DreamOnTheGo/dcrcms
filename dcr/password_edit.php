<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;查看订单</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>查看订单</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<form action="password_action.php" method="post" style="margin:0">
<input type="hidden" name="action" id="action" value="changpas">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD width="100" align=right bgcolor="#FFFFFF">原密码：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="oldpassword" type="password" id="oldpassword"></TD>
  </TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">新密码：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="newpassword1" type="password" id="newpassword1"></TD>
  </TR>
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">重复新密码：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="newpassword2" type="password" id="newpassword2"></TD>
  </TR>
  <TR>
    <TD align=right bgcolor="#FFFFFF"></TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="修改密码"></TD></TR>
    </TABLE>
 </form>
 </BODY></HTML>