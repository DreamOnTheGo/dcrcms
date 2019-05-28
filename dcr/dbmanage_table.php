<?php
include "../include/common.inc.php";
session_start();
include "adminyz.php";
if($db_type==1)
{
	show_msg('Sqlite无法使用这个功能，抱歉',1);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;数据库管理</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>数据库管理</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
  <TABLE cellSpacing=1 cellPadding=2 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD align="left" style="text-align: left"><?php include_once "dbmanage_header.php"; ?></TD>
    </TR>    
    </TABLE>
    <script>
	function do_action(action)
	{
		document.getElementById('action').value=action;
		document.getElementById('frm').submit();
	}
    </script>
<form action="dbmanage_table_action.php" method="post" id="frm" target="frame_action">
<input type="hidden" name="action" id="action" value="">
<?php
	//数据库的列表'
	include_once WEB_CLASS . "/class.db.bak.php";
	$db_bak=new cls_db_bak($db);
	$table_list=$db_bak->get_table_list();
	sort($table_list);
	$table_num=count($table_list);
?>
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
<tr>
      <TD bgcolor="#FFFFFF" style="text-align:left">
      <select name="table_name" id="table_name" style="width:100%" size="12">
	  <?php for($i=0;$i<$table_num;$i++){ ?>
<option value='<?php echo $table_list[$i]; ?>'><?php echo $table_list[$i]; ?>	</option>  
<?php }?> </select></TD></tr>

	<tr>
	  <TD bgcolor="#FFFFFF" colspan="4" style="text-align:left"><input type="button" name="button" id="button" value="优化选中表" onClick="javascript:do_action('opimize');">  <input type="button" name="button" id="button" value="优化全部表" onClick="javascript:do_action('opimize_all');">  <input type="button" name="button" id="button" value="查看表结构" onClick="javascript:do_action('view_info');">  <input type="button" name="button" id="button" value="修复选中表" onClick="javascript:do_action('repair');">   <input type="button" name="button" id="button" value="修复全部表" onClick="javascript:do_action('repair_all');"></TD>
    </tr>
    </TABLE>
 </form>

<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
	<tr>
	  <TD bgcolor="#FFFFFF" colspan="4" style="text-align:left"><iframe name="frame_action" frameborder="0" scrolling="auto" width="100%" height="300"></iframe></TD>
    </tr>
    </TABLE> 
 </BODY></HTML>