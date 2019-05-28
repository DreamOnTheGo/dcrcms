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
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;资料列表</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>资料列表</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
<form action="single_action.php" method="post">
<input type="hidden" name="action" id="action" value="delsingle">
<TABLE cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD style="text-align: center" width=56>ID</TD>
    <TD width="534" style="text-align: center">标题</TD>
    <TD width="183" style="text-align: center">加入时间</TD>
    <TD width="132" style="text-align: center">操作</TD>
  </TR>
  <?php
	require_once(WEB_CLASS . "/class.single.php");
	$page_list_num = 20;//每页显示?条
	$total_page = 0;//总页数
	$page = isset($page) ? (int)$page : 1;
	$start = ($page-1) * $page_list_num;
	$cls_single = new cls_single();
	$single_list = $cls_single->get_list(array('col'=>'id,title,updatetime', 'order'=>'id desc', 'limit'=>"$start,$page_list_num"));
	foreach($single_list as $value)
	{
		$id = $value['id'];
  ?>  
  <TR>
    <TD bgcolor="#FFFFFF" style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $id; ?>"><?php echo $id; ?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: left"><a href="single_edit.php?action=modify&id=<?php echo $id; ?>"><?php echo $value['title']; ?></a></TD>
    <TD bgcolor="#FFFFFF" style="text-align: center"><?php echo $value['updatetime']; ?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: center"><a href="single_edit.php?action=modify&id=<?php echo $id; ?>">编辑</a></TD>
  </TR>    
  <?php } ?>  
  <TR>
    <TD colspan="5" bgcolor="#FFFFFF" align="right">
    <?php
	require_once(WEB_CLASS.'/class.page.php');
	$info_sum = $cls_single->select_one(array('col'=>'count(id) as sum'));
	$info_sum = current($info_sum);
	$page_num = $info_sum['sum'];
	$total_page = ceil($page_num / $page_list_num);//总页数
			
	$cls_page=new cls_page($page, $total_page);
	$showpage = $cls_page->show_page(); 
	echo $showpage;
	?>
    </TD>
    </TR>  
  <TR>
    <TD colspan="5" bgcolor="#FFFFFF"><input type="button" name="button" id="button" value="全选/反选" onClick="javascript:selectAllChk('id[]');">
      &nbsp; <input type="submit" name="button2" id="button2" value="删除" onclick="return confirm('确定要删除?');"></TD>
    </TR>  
    </TABLE>
 </form>
 </BODY></HTML>