<?php
require_once("../include/common.inc.php");
session_start();
require_once("adminyz.php");
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
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;友情链接列表</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>首页幻灯列表</td></tr>
  <tr bgColor=#ecf4fc height=24>
    <td style="padding:4px;"><a href="huandeng_edit.php?action=add">添加幻灯</a> <a href="huandeng_list.php">幻灯列表</a></td></tr>
  </table>
<form action="zw_action.php" method="post">
<input type="hidden" name="action" id="action" value="delzw">
<table cellSpacing=2 cellPadding=5 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td style="text-align: center" width=8%>ID</td>
    <td width="21%" style="text-align: center">链接地址</td>
    <td width="26%" style="text-align: center">图片</td>
    <td width="15%" style="text-align: center">操作</td>
  </tr>
  <?php
	$page_list_num = 10;//每页显示?条
	$total_page = 0;//总页数
	$page = isset($page) ? (int)$page : 1;
	$start = ($page-1) * $page_list_num;
	
	require_once(WEB_CLASS . '/class.data.php');
	$huandeng_data = new cls_data('{tablepre}huandeng');
	$list = $huandeng_data-> select_ex(array('limit'=>"$start,$page_list_num", 'where'=>$where, 'order'=>'id desc'));
	//p_r($list);
	foreach($list as $value){
  ?>  
  <tr height="30" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $value['id']; ?>"><?php echo $value['id']; ?></td>
    <td style="text-align: left"><?php echo $value['url']; ?></td>
    <td style="text-align: center"><?php if($value['logo']){ ?><img width="200" src="../uploads/huandeng/<?php echo $value['logo']; ?>" /><?php }else{ ?><?php } ?></td>
    <td style="text-align: center"><a href="huandeng_edit.php?action=edit&id=<?php echo $value['id']; ?>">编辑</a>  <a href="huandeng_action.php?action=del&id=<?php echo $value['id']; ?>"  onclick="return confirm('确定要删除吗？');">删除</a></td>
  </tr>    
  <?php } ?>  
  <tr>
    <td colspan="7" bgcolor="#FFFFFF" align="right">
	<?php
		require_once(WEB_CLASS . '/class.page.php');
		$info_num = $huandeng_data->select_one_ex( array('col'=>'count(id) as sum', 'where'=>$where) );
		$page_num = $info_num['sum'];
		$total_page = ceil($page_num / $page_list_num);//总页数
						
		$cls_page = new cls_page($page, $total_page);
		$page_html = $cls_page->show_page(); 
		echo $page_html;
	?>
    </td>
    </tr>      
    </table>
 </form>
 </body></html>