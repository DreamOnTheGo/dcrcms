<?php
include "../include/common.inc.php";
session_start();
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
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;导入模板</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" align=middle background=images/title_bg2.jpg>导入模板</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<form action="tpl_import_action.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" id="action" value="changpas">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <?php if(!$issystem){ ?>
  <TR>
    <TD width="146" align=right valign="top" bgcolor="#FFFFFF">模板配置文件：</TD>
    <TD width="924" bgcolor="#FFFFFF" style="COLOR: #880000"><input type="file" name="configfile" id="configfile" />
    (默认情况下，配置文件为模板目录下的tpl.config，如default/tpl.config)</TD>
  </TR>
  <?php } ?>
  <TR>
    <TD align=right bgcolor="#FFFFFF"></TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="开始导入"></TD></TR>
    </TABLE>
</form>
 </BODY></HTML>