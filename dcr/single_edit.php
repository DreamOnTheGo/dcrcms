<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
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
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;添加资料</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>添加资料</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td></tr>
  </table>
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
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">  
  <tr>
    <td width=100 align=right bgcolor="#FFFFFF">资料标题(<font color="red" class="txtRed">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input name="title" type="text" id="title" size="80" value="<?php echo $singleinfo['title']; ?>"></td></tr>    
  <tr>
    <td align=right valign="top" bgcolor="#FFFFFF">资料内容(<font color="red">*</font>)：</td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000">    
    <?php APP::GetEditor('content',$singleinfo['content'],'930','500');?>
    </td></tr>
  <tr>
    <td align=right bgcolor="#FFFFFF"></td>
    <td bgcolor="#FFFFFF" style="COLOR: #880000"><input type="submit" name="button" id="button" value="<?php if($action=='add'){echo '添加';}else{echo '修改';} ?>资料">
    <input type="reset" name="button2" id="button2" value="重置"></td></tr>
    </table>
 </form>
 </body></html>