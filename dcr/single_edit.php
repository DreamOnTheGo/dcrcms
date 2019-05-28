<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<?php include "admin_common.php"; ?>
<script type='text/javascript'>
function check(){
	if($("#title").val().length==0){
		ShowMsg('请输入资料标题');
		return false;
	}
	if(getFckeditorText("content").length==0){
		ShowMsg('请输入资料内容');
		return false;
	}
}
</script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;添加资料</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>添加资料</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<?php
	include WEB_CLASS."/single_class.php";
	$single=new Single();
	if($action=='add'){
	}else{
		$action='modify';
		$id=isset($id)?(int)$id:0;
		if($id!=0){
			$singleinfo=$single->GetInfo($id);
		}else{
			ShowMsg('您没有选择要修改的文档');
		}
	}
?>
<form action="single_action.php" method="post" id="frmAddNews" name="frmAddNews" onsubmit="return check();">
<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $singleinfo['id']; ?>">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
  <TR>
    <TD width=100 align=right bgcolor="#FFFFFF">资料标题(<font color="red" class="txtRed">*</font>)：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input name="title" type="text" id="title" size="80" value="<?php echo $singleinfo['title']; ?>"></TD></TR>    
  <TR>
    <TD align=right valign="top" bgcolor="#FFFFFF">资料内容(<font color="red">*</font>)：</TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><?php
include(WEB_INCLUDE."/editor/fckeditor.php");
$editor = new FCKeditor('content') ;
$editor->BasePath = '../include/editor/';
$editor->ToolbarSet='Default'; //工具按钮设置
$editor->Width = '100%' ; 
$editor->Height = '500' ; 
$editor->Value =$singleinfo['content'];
$editor->Create() ;
?></TD></TR>
  <TR>
    <TD align=right bgcolor="#FFFFFF"></TD>
    <TD bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '添加';}else{echo '修改';} ?>资料">
    <input type="reset" name="button2" id="button2" value="重置"></TD></TR>
    </TABLE>
 </form>
 </BODY></HTML>