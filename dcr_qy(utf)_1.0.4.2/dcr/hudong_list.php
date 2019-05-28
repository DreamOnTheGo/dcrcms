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
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;订单列表</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>订单列表</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td></tr>
  </table>
<form action="hudong_action.php" method="post">
<input type="hidden" name="action" id="action" value="delorder">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td style="text-align: center" width=56>ID</td>
    <td width="581" style="text-align: center">留言者</td>
    <td width="122" style="text-align: center">处理状态</td>
    <td width="161" style="text-align: center">加入时间</td>
    <td width="114" style="text-align: center">操作</td>
  </tr>
  <?php
	include WEB_CLASS."/hudong_class.php";
	$pageListNum=20;//每页显示9条
	$totalPage=0;//总页数
	$page=isset($page)?(int)$page:1;
	$type=isset($type)?(int)$type:0;
	$start=($page-1)*$pageListNum;
	$hudong=new HuDong;
	$hudongList=$hudong->GetList(array('id','type','title','updatetime'),$type,$start,$pageListNum,'updatetime desc');
	foreach($hudongList as $value){
  ?>  
  <tr height="30" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $value['id']; ?>"></td>
    <td style="text-align: left"><a href="hudong_edit.php?id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a></td>
    <td style="text-align: left"><?php if($value['type']==1){echo '未处理';}else{echo '已处理';} ?></td>
    <td style="text-align: center"><?php echo $value['updatetime']; ?></td>
    <td style="text-align: center"><a href="hudong_edit.php?id=<?php echo $value['id']; ?>">查看</a></td>
  </tr>    
  <?php } ?>  
  <tr>
    <td colspan="5" bgcolor="#FFFFFF" align="right">
    <?php
	require_once(WEB_CLASS.'/page_class.php');
	
	$rsnum=$hudong->GetNum($type);
	$totalPage=ceil($rsnum/$pageListNum);//总页数
			
	$page=new PageClass($page,$totalPage);
	$showpage=$page->showPage(); 
	echo $showpage;
	?>
    </td>
    </tr>  
  <tr>
    <td colspan="5" bgcolor="#FFFFFF"><input type="button" name="button" id="button" value="全选/反选" onClick="javascript:selectAllChk('id[]');">
      &nbsp; <input type="submit" name="button2" id="button2" value="删除"></td>
    </tr>  
    </table>
 </form>
 </body></html>