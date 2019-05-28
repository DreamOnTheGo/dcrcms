<?php
session_start();
include "../include/common.inc.php";
include "adminyz.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script></head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;职位列表</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>职位列表</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td></tr>
  </table>
<form action="zw_action.php" method="post">
<input type="hidden" name="action" id="action" value="delzw">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td style="text-align: center" width=8%>ID</td>
    <td width="21%" style="text-align: center">网站名</td>
    <td width="30%" style="text-align: center">网址</td>
    <td width="26%" style="text-align: center">LOGO</td>
    <td width="15%" style="text-align: center">操作</td>
  </tr>
  <?php
	$pageListNum=20;//每页显示?条
	$totalPage=0;//总页数
	$page=isset($page)?(int)$page:1;
	$start=($page-1)*$pageListNum;
	
	include WEB_CLASS.'article_class.php';
	$art=new Article('{tablepre}flink');
	$list=$art->GetList(array(),$start,$pageListNum,$where,'id desc');
	foreach($list as $value){
  ?>  
  <tr height="30" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $value['id']; ?>"><?php echo $value['id']; ?></td>
    <td style="text-align: left"><?php echo $value['webname']; ?></td>
    <td style="text-align: left"><?php echo $value['weburl']; ?></td>
    <td style="text-align: center"><?php if($value['logo']){ ?><img src="../uploads/flink/<?php echo $value['logo']; ?>" /><?php }else{ ?><?php } ?></td>
    <td style="text-align: center"><a href="flink_edit.php?action=editflink&id=<?php echo $value['id']; ?>">编辑</a>  <a href="flink_action.php?action=delflink&id=<?php echo $value['id']; ?>"  onclick="return confirm('确定要删除吗？');">删除</a></td>
  </tr>    
  <?php } ?>  
  <tr>
    <td colspan="7" bgcolor="#FFFFFF" align="right">
				<?php
				require_once(WEB_CLASS.'/page_class.php');
				$pageNum=count($art->GetList(array('id'),'','',$where));
				$totalPage=ceil($pageNum/$pageListNum);//总页数
						
				$page=new PageClass($page,$totalPage);
				$showpage=$page->showPage(); 
				echo $showpage;
				?>
    </td>
    </tr>      
    </table>
 </form>
 </body></html>