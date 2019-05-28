<?php
include "../include/common.inc.php";
session_start();
include "adminyz.php";
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
<form action="dbmanage_action.php" method="post" target="frame_action">
<input type="hidden" name="action" id="action" value="restore_db">
<?php
	//数据库的列表'
	require_once(WEB_CLASS . "/class.dir.php");
	$cls_file = new cls_dir(WEB_MYSQL_BAKDATA_DIR);
	$file_list = $cls_file-> get_file_list();
	//p_r($file_list);
	sort($file_list);
	$file_num = count($file_list);
?>
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
<?php for($i=0;$i<$file_num;$i++){ ?>
	<?php if($i%2==0){ ?><tr><?php } ?>
      <TD bgcolor="#FFFFFF" style="text-align:left"><input type="checkbox" name="file_list[]" id="file_list[]" value="<?php echo $file_list[$i]['filename']; ?>" checked="checked" /><?php echo $file_list[$i]['filename']; ?></TD>
	<?php if($i%2==1){ ?></tr>
	<?php } ?>
<?php }?>
	<tr>
	  <TD bgcolor="#FFFFFF" colspan="4" style="text-align:left"><input type="button" name="button" id="button" value="全选/反选" onClick="javascript:selectAllChk('file_list[]');">  <input type="submit" name="button" id="button" value="开始还原" /></TD>
    </tr>
    </TABLE>
 </form>

<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
	<tr>
	  <TD bgcolor="#FFFFFF" colspan="4" style="text-align:left"><iframe name="frame_action" frameborder="0" width="100%" height="500"></iframe></TD>
    </tr>
    </TABLE> 
 </BODY></HTML>