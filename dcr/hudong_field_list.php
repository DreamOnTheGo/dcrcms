<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>

</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;信息字段管理</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg><span style="float:right;"></span>信息字段管理</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td><a href="hudong_field_edit.php?action=add">添加字段</a>  <a href="hudong_field_getform.php">生成表单</a></td></tr>
  </table>
<form action="hudong_field_action.php" method="post">
<input type="hidden" name="action" id="action" value="order">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td width="20%" style="text-align: center">表单提示文字</td>
    <td width="20%" style="text-align: center">数据字段名</td>
    <td width="20%" style="text-align: center">数据类型</td>
    <td width="20%" style="text-align: center">操作</td>
    <td width="20%" style="text-align: center">排序</td>
    </tr>
  <tr>
    <td colspan="5" style="text-align: center">除了下面列出的字段，还有一个固定的字段：title(标题) 固化在表单中</td>
    </tr>
  <?php
	include WEB_CLASS."/hudong_class.php";
	$hudong=new HuDong;
	$hudongFiledList=$hudong->GetFiledList();
	foreach($hudongFiledList as $value){
  ?>  
  <tr height="30" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td style="text-align: center"><?php echo $value['itemname']; ?></td>
    <td style="text-align: left"><?php echo $value['fieldname']; ?></td>
    <td style="text-align: center"><?php echo $value['dtype']; ?></td>
    <td style="text-align: center"><a href="hudong_field_edit.php?id=<?php echo $value['id']; ?>&action=modify">编辑 </a><a href="hudong_field_action.php?id=<?php echo $value['id']; ?>&action=delfield">删除</a></td>
    <td style="text-align: center"><input name="orderid[<?php echo $value['id']; ?>]" id="orderid[<?php echo $value['id']; ?>]" type="text" size="5" value="<?php echo $value['orderid']; ?>" /></td>
  </tr>    
  <?php } ?>      
  <tr>
    <td colspan="6" bgcolor="#FFFFFF" align="right"><input type="submit" name="button" id="button" value="排序"></td>
    </tr>  
    </table>
 </form>
 </body></html>