<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>
<script src="../include/js/jquery.js"></script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;生成信息表单</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg><span style="float:right;"></span>生成信息表单</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
</TABLE>
<?php
	require_once(WEB_CLASS . "/class.hudong.php");
	$cls_hudong = new cls_hudong();
	$form_txt = $cls_hudong-> get_field_form();
?>
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
  <tr>
    <td colspan="2" bgcolor="#FFFFFF" style="text-align: left">
    <textarea name="frmTxt" cols="145" rows="25" id="frmTxt" type="text"><?php echo htmlspecialchars($form_txt); ?></textarea></td>
  </tr>
  <?php //} ?>
  <TR>
    <TD colspan="2" bgcolor="#FFFFFF" align="center"><input type="button" name="button" id="button" value="请手动复制上面的代码到您需要的地方粘贴"></TD>
    </TR>  
    </TABLE>
</BODY></HTML>