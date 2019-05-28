<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <TR height=28>
    <TD background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;新闻列表</TD></TR>
  <TR>
    <TD bgColor=#b1ceef height=1></TD></TR></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <TR height=20>
    <TD></TD></TR>
  <TR height=22>
    <TD style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>添加新闻</TD></TR>
  <TR bgColor=#ecf4fc height=12>
    <TD></TD></TR>
  </TABLE>
  <TABLE cellSpacing=1 cellPadding=2 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD align="left" style="text-align: left">新闻分类：<?php 
	include WEB_CLASS."/news_class.php";
	$news=new News(0);
	$newsClassList=$news->GetClassList(array('id','classname'),'','','id desc');
	foreach($newsClassList as $value){
		echo "<a href='news_list.php?classid=".$value['id']."'>".$value['classname'].'</a>  ';
	}
		?></TD>
    </TR>    
    </TABLE>
<form action="news_action.php" method="post">
<input type="hidden" name="action" id="action" value="delnews">
<TABLE cellSpacing=1 cellPadding=2 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <TR>
    <TD style="text-align: center" width=56>ID</TD>
    <TD width="436" style="text-align: center">标题</TD>
    <TD width="206" style="text-align: center">新闻分类</TD>
    <TD width="201" style="text-align: center">加入时间</TD>
    <TD width="171" style="text-align: center">操作</TD>
  </TR>
  <?php
	$pageListNum=20;//每页显示9条
	$totalPage=0;//总页数
	$page=isset($page)?(int)$page:1;
	$classid=isset($classid)?intval($classid):0;
	$start=($page-1)*$pageListNum;
	$newslist=$news->GetList($classid,array('id','classid','logo','istop','title','addtime'),$start,$pageListNum,'istop desc,id desc');
	foreach($newslist as $value){
  ?>  
  <TR>
    <TD bgcolor="#FFFFFF" style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $value['id']; ?>"><?php echo $value['id']; ?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: left"><a href="news_edit.php?action=modify&id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a><?php if(!empty($value['logo'])){ ?>&nbsp;<span class="txtRed">[图]</span><?php } ?><?php if($value['istop']){ ?>&nbsp;<span class="txtRed">[顶]</span><?php } ?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: center"><?php
		$t_newsclassinfo=$news->GetClassInfo($value['classid']);
		echo "<a href='news_list.php?classid=".$t_newsclassinfo['id']."'>".$t_newsclassinfo['classname'].'</a>  ';
	?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: center"><?php echo $value['addtime']; ?></TD>
    <TD bgcolor="#FFFFFF" style="text-align: center"><a href="news_edit.php?action=modify&id=<?php echo $value['id']; ?>">编辑</a><?php if(!$value['istop']){ ?>&nbsp;<a href="news_action.php?action=top&page=<?php echo $page; ?>&id=<?php echo $value['id']; ?>">置顶</a><?php }else{ ?>&nbsp;<a href="news_action.php?action=top_no&page=<?php echo $page; ?>&id=<?php echo $value['id']; ?>">取消置顶</a><?php } ?></TD>
  </TR>    
  <?php } ?>  
  <TR>
    <TD colspan="5" bgcolor="#FFFFFF" align="right">
    <?php
	require_once(WEB_CLASS.'/page_class.php');
	$sqlNum="select id from {tablepre}news";
	$db->Execute($sqlNum);
	$pageNum=$db->GetRsNum();
	$totalPage=ceil($pageNum/$pageListNum);//总页数
			
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