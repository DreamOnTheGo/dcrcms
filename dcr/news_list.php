<?php
require_once("../include/common.inc.php");
session_start();
if( 'change_page_list_num' == $action )
{
	put_cookie( 'newslist_page_list_num', $num, 100000 );
	$page_list_num = $num;
}else
{
	$page_list_num_cookie = get_cookie( 'newslist_page_list_num' );
	$page_list_num = !empty( $page_list_num_cookie ) ? intval( $page_list_num_cookie ) : 20;
}
require_once("adminyz.php");
$cls_news = cls_app::get_news();
$class_list = $cls_news->get_class_list();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="css/admin.css" type="text/css" rel="stylesheet">
<script src="../include/js/common.js"></script>
<script type="text/javascript">
	function change_page_list_num()
	{
		var url = "?action=change_page_list_num&num=" + document.getElementById("page_list_num").value;
		window.location = url;
	}
</script>
</head>
<body>
<table cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
  <tr height=28>
    <td background=images/title_bg1.jpg>当前位置: <a href="main.php">后台首页</a>&gt;&gt;新闻列表</td></tr>
  <tr>
    <td bgColor=#b1ceef height=1></td></tr></table>
<table cellSpacing=0 cellPadding=0 width="95%" align=center border=0>
  <tr height=20>
    <td></td></tr>
  <tr height=22>
    <td style="PADDING-LEFT: 20px; FONT-WEIGHT: bold; COLOR: #ffffff" 
    align=middle background=images/title_bg2.jpg>添加新闻</td></tr>
  <tr bgColor=#ecf4fc height=12>
    <td></td></tr>
  </table>
  <table cellSpacing=1 cellPadding=2 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td align="left" style="text-align: left"><form method="get">网站标题：<input name="title" type="text" value="<?php echo $title; ?>" /><input type="submit" value="搜索" />
    </form>
	</td>
    </tr>    
    </table>
  <table cellSpacing=1 cellPadding=2 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td align="left" style="text-align: left">
    <form action="" method="get">
  	  新闻分类:
      <select name="classid" id="classid">
      <option>全部分类</option>
    <?php
		$cls_news->get_class_list_select( $class_list, $classid );
	?></select>
  	<input type="submit" name="button3" id="button3" value="进入分类" />
  	</form>
    </td>
    </tr>    
    </table>
<form action="news_action.php" method="post">
<input type="hidden" name="action" id="action" value="delnews">
<table cellSpacing=1 cellPadding=2 width="95%" align=center border=0 bgcolor="#ecf4fc">
  <tr>
    <td style="text-align: center" width=66>ID</td>
    <td width="374" style="text-align: center">标题</td>
    <td width="164" style="text-align: center">新闻分类</td>
    <td width="157" style="text-align: center">添加时间</td>
    <td width="162" style="text-align: center">更新时间</td>
    <td width="158" style="text-align: center">操作</td>
  </tr>
  <?php
  	if(!empty($title))
	{
		$where = "title like '%$title%'";
	}
	
	$total_page = 0;//总页数
	$page = isset($page) ? (int)$page : 1;
	$classid = isset($classid) ? intval($classid) : 0;
	$start = ($page-1) * $page_list_num;
	$news_list = $cls_news->get_list($classid, array('col'=>'id,classid,logo,istop,title,addtime,updatetime', 'limit'=>"$start, $page_list_num", 'order'=>'istop desc,id desc', 'where'=>$where));
	foreach($news_list as $value)
	{
  ?>  
  <tr height="30" bgcolor="#FFFFFF" onMouseMove="javascript:this.style.backgroundColor='#F4F9EB';" onMouseOut="javascript:this.style.backgroundColor='#FFFFFF';">
    <td style="text-align: center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $value['id']; ?>"><?php echo $value['id']; ?></td>
    <td style="text-align: left"><a href="news_edit.php?action=modify&id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a><?php if(!empty($value['logo'])){ ?>&nbsp;<span class="txtRed">[图]</span><?php } ?><?php if($value['istop']){ ?>&nbsp;<span class="txtRed">[顶]</span><?php } ?></td>
    <td style="text-align: center"><?php
		$t_newsclassinfo = $cls_news->get_class_info($value['classid']);
		echo "<a href='news_list.php?classid=" . $t_newsclassinfo['id'] . "'>" . $t_newsclassinfo['classname'] . '</a>  ';
	?></td>
    <td style="text-align: center"><?php echo $value['addtime']; ?></td>
    <td style="text-align: center"><?php echo $value['updatetime']; ?></td>
    <td style="text-align: center"><a href="news_edit.php?action=modify&id=<?php echo $value['id']; ?>">编辑</a><?php if(!$value['istop']){ ?>&nbsp;<a href="news_action.php?action=top&page=<?php echo $page; ?>&id=<?php echo $value['id']; ?>">置顶</a><?php }else{ ?>&nbsp;<a href="news_action.php?action=top_no&page=<?php echo $page; ?>&id=<?php echo $value['id']; ?>">取消置顶</a><?php } ?>&nbsp;<a href="news_action.php?action=delsinglenews&id=<?php echo $value['id']; ?>" onclick="return confirm('确定要删除?');">删除</a></td>
  </tr>    
  <?php } ?>  
  <tr>
    <td colspan="6" bgcolor="#FFFFFF">
    <div style="float:left;">每页显示条目数:&nbsp;<input type="text" id="page_list_num" name="page_list_num" value="<?php echo $page_list_num; ?>" size="5" /><input type="button" onclick="change_page_list_num()" value="更改" /></div>
    <div style="float:right">
    <?php
	require_once(WEB_CLASS.'/class.page.php');
	$page_num = $cls_news-> get_news_count($classid, $where);
	$total_page = ceil($page_num/$page_list_num);//总页数
			
	$cls_page = new cls_page($page, $total_page);
	$page_html = $cls_page->show_page(); 
	echo $page_html;
	?>
    </div>
    </td>
    </tr>  
  <tr>
    <td colspan="6" bgcolor="#FFFFFF"><input type="button" name="button" id="button" value="全选/反选" onClick="javascript:selectAllChk('id[]');">
      &nbsp; <input type="submit" name="button2" id="button2" onclick="return confirm('确定要删除?');" value="删除"></td>
    </tr>  
    </table>
 </form>
 </body></html>