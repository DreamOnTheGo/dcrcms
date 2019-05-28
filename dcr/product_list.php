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
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;产品分类列表</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>产品列表</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td></tr>
  </table>
  <table cellSpacing=1 cellPadding=2 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td align="left" style="text-align: left">产品分类：<?php 
	include WEB_CLASS."/product_class.php";
	$pc=new Product(0);
	$proClassList=$pc->GetClassList(array('id','classname'),'','','id desc');
	if($proClassList)
	{
		foreach($proClassList as $value){
			echo "<a href='product_list.php?classid=".$value['id']."'>".$value['classname'].'</a>  ';
		}
	}
		?></td>
    </tr>    
    </table>
<form action="product_action.php" method="post">
<input type="hidden" name="action" id="action" value="delproduct">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td style="text-align: center" width=75>ID</td>
    <td width="443" style="text-align: center">标题</td>
    <td width="145" style="text-align: center">产品类别</td>
    <td width="161" style="text-align: center">加入时间</td>
    <td width="142" style="text-align: center">操作</td>
  </tr>
  <?php
	$pageListNum=20;//每页显示?条
	$totalPage=0;//总页数
	$page=isset($page)?(int)$page:1;
	$start=($page-1)*$pageListNum;
	$classid=isset($classid)?intval($classid):0;
	$productClassList=$pc->GetList($classid,array('id','title','istop','classid','logo','updatetime'),$start,$pageListNum,'','',1);
	foreach($productClassList as $value){
  ?>  
  <tr height="30" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $value['id']; ?>"><?php echo $value['id']; ?></td>
    <td style="text-align: left"><a href="product_edit.php?action=modify&id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a></td>
    <td style="text-align: center">
	<?php
		$t_proclassinfo=$pc->GetClassInfo($value['classid']);
		echo "<a href='product_list.php?classid=".$t_proclassinfo['id']."'>".$t_proclassinfo['classname'].'</a>  ';
	?></td>
    <td style="text-align: center"><?php echo $value['updatetime']; ?></td>
    <td style="text-align: center"><a href="product_edit.php?action=modify&id=<?php echo $value['id']; ?>">编辑</a><?php if(!$value['istop']){ ?>&nbsp;<a href="product_action.php?action=top&page=<?php echo $page; ?>&id=<?php echo $value['id']; ?>">置顶</a><?php }else{ ?>&nbsp;<a href="product_action.php?action=top_no&page=<?php echo $page; ?>&id=<?php echo $value['id']; ?>">取消置顶</a><?php } ?>&nbsp;<a href="product_action.php?action=delsingleproduct&id=<?php echo $value['id']; ?>" onclick="return confirm('确定要删除?');">删除</a></td>
  </tr>    
  <?php } ?>  
  <tr>
    <td colspan="5" bgcolor="#FFFFFF" align="right">
    <?php
	require_once(WEB_CLASS.'/page_class.php');
	$sqlNum="select id from {tablepre}product";
	$db->Execute($sqlNum);
	$pageNum=$db->GetRsNum();
	$totalPage=ceil($pageNum/$pageListNum);//总页数
			
	$page=new PageClass($page,$totalPage);
	$showpage=$page->showPage(); 
	echo $showpage;
	?>
    </td>
    </tr>  
  <tr>
    <td colspan="5" bgcolor="#FFFFFF"><input type="button" name="button" id="button" value="全选/反选" onClick="javascript:selectAllChk('id[]');">
      &nbsp; <input type="submit" name="button2" id="button2" value="删除" onclick="return confirm('确定要删除?');"></td>
    </tr>  
    </table>
 </form>
 </body></html>