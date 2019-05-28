<?php
session_start();
include "../include/common.inc.php";
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
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;订单列表</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>订单列表</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<form action="hudong_action.php" method="post">
<input type="hidden" name="action" id="action" value="delorder">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD style="text-align: center" width=56>ID</TD>
    <TD width="581" style="text-align: center">留言者</TD>
    <TD width="122" style="text-align: center">处理状态</TD>
    <TD width="161" style="text-align: center">加入时间</TD>
    <TD width="114" style="text-align: center">操作</TD>
  </TR>
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
  <TR>
    <TD bgcolor="#FFFFFF" style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $value['id']; ?>"></TD>
    <TD bgcolor="#FFFFFF" style="text-align: left"><a href="hudong_edit.php?id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a></TD>
    <TD bgcolor="#FFFFFF" style="text-align: left"><?php if($value['type']==1){echo '未处理';}else{echo '已处理';} ?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: center"><?php echo $value['updatetime']; ?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: center"><a href="hudong_edit.php?id=<?php echo $value['id']; ?>">查看</a></TD>
  </TR>    
  <?php } ?>  
  <TR>
    <TD colspan="5" bgcolor="#FFFFFF" align="right">
    <?php
	require_once(WEB_CLASS.'/page_class.php');
	
	$rsnum=$hudong->GetNum($type);
	$totalPage=ceil($rsnum/$pageListNum);//总页数
			
	$page=new PageClass($page,$totalPage);
	$showpage=$page->showPage(); 
	echo $showpage;
	?>
    </TD>
    </TR>  
  <TR>
    <TD colspan="5" bgcolor="#FFFFFF"><input type="button" name="button" id="button" value="全选/反选" onClick="javascript:selectAllChk('id[]');">
      &nbsp; <input type="submit" name="button2" id="button2" value="删除"></TD>
    </TR>  
    </TABLE>
 </form>
 </BODY></HTML>